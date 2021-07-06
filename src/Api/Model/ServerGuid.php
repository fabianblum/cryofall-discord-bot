<?php

declare(strict_types=1);

namespace App\Api\Model;

class ServerGuid
{
    public function __construct(private string $guid)
    {
    }

    public function __toString(): string
    {
        return $this->guid;
    }
}