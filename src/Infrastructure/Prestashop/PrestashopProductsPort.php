<?php

declare(strict_types=1);

namespace App\Infrastructure\Prestashop;

use App\Domain\Aggregate\Product\Product;
use App\Domain\ProductAdapter;
use App\Domain\VO\Availability;
use App\Domain\VO\Image;
use App\Domain\VO\Price;
use App\Domain\VO\Variation;
use DateTime;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Throwable;

class PrestashopProductsPort implements ProductAdapter
{
    private PrestashopClient $client;

    public function __construct(PrestashopClient $client)
    {
        $this->client = $client;
    }

    private function toDateTime(string $date): DateTime
    {
        try {
            $dateTime = new DateTime(str_replace('(Coordinated Universal Time)', '', $date));
        } catch (Exception $e) {
            $dateTime = new DateTime();
        }

        return $dateTime;
    }

    /**
     * @return Product[]
     * @throws Exception
     */
    public function findAllProducts(): array
    {
        try {
            $products = $this->client->executeOperation();
        } catch (Throwable $t) {
            throw new Exception($t->getMessage());
        }

        $sanitizedProducts = [];
        foreach ($products['products'] as $product) {
            $images = [];
            foreach ($product['image'] as $image) {
                $images[] = new Image($image['url'], $image['alt']);
            }

            if ($product['price']['regular'] >= $product['price']['on_sale']) {
                $regularPrice = $product['price']['regular'];
                $onSale = $product['price']['on_sale'];
            } else {
                $onSale = $product['price']['regular'];
                $regularPrice = $product['price']['on_sale'];
            }

            $variationsRepetition = [];
            $newestVariation = null;
            $sanitizedVariations = [];
            $duplicatedVariation = false;
            foreach ($product['variations'] as $variation) {
                $sanitizedVariation = new Variation(
                    $variation['id'],
                    $variation['color'],
                    $variation['material'],
                    $this->toDateTime($variation['updatedAt'])
                );

                $sanitizedVariations[] = $sanitizedVariation;

                // To control potential repetition of color-material in the variations of the product
                if (isset($variationsRepetition[$variation['color'] . $variation['material']])) {
                    $duplicatedVariation = true;
                } else {
                    $variationsRepetition[$variation['color'] . $variation['material']] = 1;
                }

                // Update the newest variation. We'll use it in case there is a repetition in the variations of the product
                if ($newestVariation === null) {
                    $newestVariation = $sanitizedVariation;
                } elseif ($sanitizedVariation->getUpdatedAt() < $newestVariation->getUpdatedAt()) {
                    $newestVariation = $sanitizedVariation;
                }
            }
            // If there are repetitions, we take the newest one
            if ($duplicatedVariation) {
                $sanitizedVariations = [$newestVariation];
            }

            $sanitizedProducts[] = new Product(
                $product['id'],
                $product['name'],
                $product['description'],
                $product['link'],
                new Availability($product['availability']['stock']),
                new Price($regularPrice, $onSale),
                $images,
                $sanitizedVariations,
                $this->toDateTime($product['updatedAt'])
            );
        }

        return ['products' => $sanitizedProducts];
    }
}