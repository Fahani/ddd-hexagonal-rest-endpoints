<?php

declare(strict_types=1);


namespace App\Domain\VO;


class Availability
{
    private int $stock;

    public function __construct(int $stock)
    {
        $this->stock = $stock;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
}