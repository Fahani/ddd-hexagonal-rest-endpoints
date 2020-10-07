<?php

declare(strict_types=1);

namespace App\Tests\Domain\Aggregate\Ads;

use App\Domain\Aggregate\Ads\Advertisement;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @coversDefaultClass Advertisement
 */
class AdvertisementTest extends TestCase
{
    /**
     * @covers Advertisement::getId
     * @covers Advertisement::getLink
     * @covers Advertisement::getName
     * @covers Advertisement::getColors
     * @covers Advertisement::getDiscount
     * @covers Advertisement::getImages
     * @covers Advertisement::getMaterials
     * @test
     */
    public function getMethods()
    {
        $id = Uuid::uuid4()->toString();
        $ads = new Advertisement(
            $id,
            'T-shirt',
            'https://www.example.com/t-shirt',
            ['https://www.example.com/t-shirt/image.jpg'],
            '10%',
            'New Product!',
            ['Blue', 'Red'],
            ['Cotton', 'Metal']
        );

        $this->assertEquals($id, $ads->getId());
        $this->assertEquals('T-shirt', $ads->getName());
        $this->assertEquals('https://www.example.com/t-shirt', $ads->getLink());
        $this->assertEquals(['https://www.example.com/t-shirt/image.jpg'], $ads->getImages());
        $this->assertEquals('10%', $ads->getDiscount());
        $this->assertEquals('New Product!', $ads->getMessage());
        $this->assertEquals(['Blue', 'Red'], $ads->getColors());
        $this->assertEquals(['Cotton', 'Metal'], $ads->getMaterials());
    }
}