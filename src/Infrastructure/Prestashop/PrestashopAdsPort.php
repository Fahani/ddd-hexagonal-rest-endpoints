<?php

declare(strict_types=1);

namespace App\Infrastructure\Prestashop;

use App\Domain\AdsAdapter;
use App\Domain\Aggregate\Ads\Advertisement;
use App\Domain\Aggregate\Product\Product;
use Exception;

class PrestashopAdsPort implements AdsAdapter
{
    private PrestashopProductsPort $prestashopProductsPort;

    public function __construct(PrestashopProductsPort $prestashopProductsPort)
    {
        $this->prestashopProductsPort = $prestashopProductsPort;
    }

    /**
     * @return \array[][]
     * @throws Exception
     */
    public function findAllAds(): array
    {
        try {
            $products = $this->prestashopProductsPort->findAllProducts();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        $adsEnabled = [];
        $adsDisabled = [];
        /** @var Product $product */
        foreach ($products['products'] as $product) {
            $id = $product->getId();
            $name = $product->getName();
            $link = $product->getLink();
            $images = [];
            foreach ($product->getImage() as $image) {
                $images[] = $image->getUrl();
            }
            $discount = intval(100 - (($product->getPrice()->getOnSale() * 100) / $product->getPrice()->getRegular())) . '%';

            if ($product->getAvailability()->getStock() <= 0) {
                $message = 'Out of Stock!';
            } elseif ($product->getAvailability()->getStock() < 10) {
                $message = 'Last Units!';
            } elseif ($product->getAvailability()->getStock() < 50) {
                $message = 'Bestseller!';
            } elseif ($product->getAvailability()->getStock() > 80) {
                $message = 'New Product!';
            } else {
                $message = '';
            }

            $colors = [];
            $materials = [];
            foreach ($product->getVariations() as $variation) {
                $colors[] = $variation->getColor();
                $materials[] = $variation->getMaterial();
            }

            if ($product->getAvailability()->getStock() <= 0) {
                $adsDisabled[] = new Advertisement($id, $name, $link, $images, $discount, $message, $colors, $materials);
            } else {
                $adsEnabled[] = new Advertisement($id, $name, $link, $images, $discount, $message, $colors, $materials);
            }
        }

        return ['advertisements' => [ 'enabled' => $adsEnabled, 'disabled' => $adsDisabled ]];
    }
}