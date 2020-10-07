<?php

declare(strict_types=1);

namespace App\Application\ApplicationServices;

use App\Domain\ProductAdapter;
use Symfony\Component\Serializer\Serializer;

class FetchAndSanitizeProducts
{
    private ProductAdapter $adapter;

    private Serializer $serializer;

    public function __construct(ProductAdapter $adapter, Serializer $serializer)
    {
        $this->adapter = $adapter;
        $this->serializer = $serializer;
    }

    public function execute(): string
    {
        $products = $this->adapter->findAllProducts();

        return $this->serializer->serialize($products, 'json');
    }
}