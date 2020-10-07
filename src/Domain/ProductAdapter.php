<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Aggregate\Product\Product;

interface ProductAdapter
{
    /**
     * @return Product[]
     */
    public function findAllProducts(): array;
}