<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ViewerCounter
{
    public function count($id): int
    {
        // Calculate # of current readers
        $currentSession = session()->getId();
        $readers = Cache::get("commentable-{$id}-readers", []);
        $now = now();

        $readers[$currentSession] = $now;

        foreach ($readers as $readerSession => $lastVisitTime) {
            // expired session
            if ($now->diffInMinutes($lastVisitTime) > 1) {
                unset($readers[$readerSession]);
            }
        }

        // save readers
        Cache::forever("commentable-{$id}-readers", $readers);
        return count($readers);
    }
}
