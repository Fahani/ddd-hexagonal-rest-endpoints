<?php

declare(strict_types=1);

namespace App\Domain;


interface AdsAdapter
{
    public function findAllAds(): array;
}