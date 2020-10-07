<?php

declare(strict_types=1);

namespace App\Application\ApplicationServices;

use App\Domain\AdsAdapter;
use Symfony\Component\Serializer\Serializer;

class CreateAdsFromProducts
{
    private AdsAdapter $adapter;

    private Serializer $serializer;

    public function __construct(AdsAdapter $adapter, Serializer $serializer)
    {
        $this->adapter = $adapter;
        $this->serializer = $serializer;
    }

    public function execute(): string
    {
        $ads = $this->adapter->findAllAds();

        return $this->serializer->serialize($ads, 'json');
    }
}