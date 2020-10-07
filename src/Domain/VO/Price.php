<?php

declare(strict_types=1);


namespace App\Domain\VO;


class Price
{
    private float $regular;
    private float $on_sale;

    public function __construct(float $regular, float $on_sale)
    {
        $this->regular = $regular;
        $this->on_sale = $on_sale;
    }

    public function getRegular(): float
    {
        return $this->regular;
    }

    public function getOnSale(): float
    {
        return $this->on_sale;
    }
}