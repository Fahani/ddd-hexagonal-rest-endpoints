<?php

declare(strict_types=1);


namespace App\Tests\Infrastructure\Prestashop;


use App\Domain\Aggregate\Ads\Advertisement;
use App\Domain\Aggregate\Product\Product;
use App\Domain\VO\Availability;
use App\Domain\VO\Image;
use App\Domain\VO\Price;
use App\Domain\VO\Variation;
use App\Infrastructure\Prestashop\PrestashopProductsPort;
use PHPUnit\Framework\TestCase;
use App\Infrastructure\Prestashop\PrestashopAdsPort;
use DateTime;

/**
 * @coversDefaultClass PrestashopAdsPort
 */
class PrestashopAdsPortTest extends TestCase
{

    private Product $expectedProduct;
    private Advertisement $expectedAds;

    public function setUp()
    {
        $availability = new Availability(5);
        $price = new Price(70.05727532816405, 49.08989279160331);
        $images = [
            new Image(
                'http://lorempixel.com/640/480',
                'Aliquid culpa rerum molestiae ut soluta voluptatem voluptatibus itaque.'
            ),
            new Image(
                'http://lorempixel.com/640/480',
                'Soluta esse velit laborum velit et.'
            )
        ];
        $variationId = '75309ab4-6bcf-4ce7-af39-49ea6f24a5a9';
        $variationDate = new DateTime('2020-09-07 21:27:51.0 +00:00');
        $variations = [new Variation($variationId, 'purple', 'Wooden', $variationDate)];
        $updatedAt = new DateTime('2020-09-07 23:48:11.0 +00:00');
        $productId = 'a440f14a-6fb7-4607-b935-a5f4f6bb09a0';
        $this->expectedProduct = new Product(
            $productId,
            'Tasty Plastic Keyboard',
            'Amet sequi rem vel consequatur ut cumque qui. Non ut aut esse. Rerum corporis voluptas modi est tene',
            'https://alexandrine.net',
            $availability,
            $price,
            $images,
            $variations,
            $updatedAt
        );

        $this->expectedAds = new Advertisement(
            'a440f14a-6fb7-4607-b935-a5f4f6bb09a0',
            'Tasty Plastic Keyboard',
            'https://alexandrine.net',
            ['http://lorempixel.com/640/480', 'http://lorempixel.com/640/480'],
            '29%',
            'Last Units!',
            ['purple'],
            ['Wooden']
        );
    }

    /**
     * @covers PrestashopAdsPort::findAllAds
     * @test
     */
    public function findAllAds()
    {
        $prestashopProductPortMock = $this->prophesize(PrestashopProductsPort::class);
        $prestashopProductPortMock->findAllProducts()
            ->shouldBeCalledTimes(1)
            ->willReturn(['products' => [$this->expectedProduct]]);

        $prestashopAdsPort = new PrestashopAdsPort($prestashopProductPortMock->reveal());

        $ads = $prestashopAdsPort->findAllAds();

        $this->assertEquals(['advertisements' => ['enabled' => [$this->expectedAds], 'disabled' => []]], $ads);
    }
}