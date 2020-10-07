<?php

declare(strict_types=1);


namespace App\Tests\Domain\Aggregate\Product;


use App\Domain\Aggregate\Product\Product;
use App\Domain\VO\Availability;
use App\Domain\VO\Image;
use App\Domain\VO\Price;
use App\Domain\VO\Variation;
use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @coversDefaultClass Product
 */
class ProductTest extends TestCase
{

    /**
     * @covers Product::getLink
     * @covers Product::getName
     * @covers Product::getId
     * @covers Product::getUpdatedAt
     * @covers Product::getVariations
     * @covers Product::getPrice
     * @covers Product::getImage
     * @covers Product::getAvailability
     * @covers Product::getDescription
     * @test
     */
    public function getMethods()
    {
        $availability = new Availability(10);
        $price = new Price(100, 50);
        $images = [new Image('http://www.example.com/image.jpg', 'Alternative Text')];
        $variationId = Uuid::uuid4()->toString();
        $variationDate = new DateTime('2020-09-07T00:19:09+00:00');
        $variations = [new Variation($variationId, 'Blue', 'Cotton', $variationDate)];
        $updatedAt = new DateTime('2020-09-08T00:19:09+00:00');
        $productId = Uuid::uuid4()->toString();
        $product = new Product(
            $productId,
            'T-shirt',
            'Beautiful t-shirt',
            'http://www.example.com/t-shirt',
            $availability,
            $price,
            $images,
            $variations,
            $updatedAt
        );

        $this->assertEquals($productId, $product->getId());
        $this->assertEquals('T-shirt', $product->getName());
        $this->assertEquals('Beautiful t-shirt', $product->getDescription());
        $this->assertEquals('http://www.example.com/t-shirt', $product->getLink());
        $this->assertEquals($availability, $product->getAvailability());
        $this->assertEquals($price, $product->getPrice());
        $this->assertEquals($images, $product->getImage());
        $this->assertEquals($variations, $product->getVariations());
        $this->assertEquals($updatedAt, $product->getUpdatedAt());
    }

}