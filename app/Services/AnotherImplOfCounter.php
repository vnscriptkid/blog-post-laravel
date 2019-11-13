<?php

namespace App\Services;

use App\Contracts\ViewerCounterContract;

class AnotherImplOfCounter implements ViewerCounterContract
{
    public function count(string $id): int
    {
        return 100;
    }
}
