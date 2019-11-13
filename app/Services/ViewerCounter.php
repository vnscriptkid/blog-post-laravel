<?php

namespace App\Services;

// use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Contracts\Session\Session as Session;

class ViewerCounter
{
    private $timeout;
    private $cache;
    private $session;

    public function __construct(Cache $cache, Session $session, int $timeout)
    {
        $this->timeout = $timeout;
        $this->cache = $cache;
        $this->session = $session;
    }

    public function count($id): int
    {
        // Calculate # of current readers
        $currentSession = $this->session->getId();
        $readers = $this->cache->get("commentable-{$id}-readers", []);
        $now = now();

        $readers[$currentSession] = $now;

        foreach ($readers as $readerSession => $lastVisitTime) {
            // expired session
            if ($now->diffInMinutes($lastVisitTime) > $this->timeout) {
                unset($readers[$readerSession]);
            }
        }

        // save readers
        $this->cache->forever("commentable-{$id}-readers", $readers);
        return count($readers);
    }
}
