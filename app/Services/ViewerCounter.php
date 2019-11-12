<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ViewerCounter
{

    public function __construct(int $timeout)
    {
        $this->timeout = $timeout;
    }

    public function count($id): int
    {
        // Calculate # of current readers
        $currentSession = session()->getId();
        $readers = Cache::get("commentable-{$id}-readers", []);
        $now = now();

        $readers[$currentSession] = $now;

        foreach ($readers as $readerSession => $lastVisitTime) {
            // expired session
            if ($now->diffInMinutes($lastVisitTime) > $this->timeout) {
                unset($readers[$readerSession]);
            }
        }

        // save readers
        Cache::forever("commentable-{$id}-readers", $readers);
        return count($readers);
    }
}
