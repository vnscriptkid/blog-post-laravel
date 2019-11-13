<?php

namespace App\Contracts;

interface ViewerCounterContract
{
    public function count(string $id): int;
}
