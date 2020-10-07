<?php

declare(strict_types=1);


namespace App\Tests\Infrastructure\Prestashop;


use App\Domain\Aggregate\Product\Product;
use App\Domain\VO\Availability;
use App\Domain\VO\Image;
use App\Domain\VO\Price;
use App\Domain\VO\Variation;
use App\Infrastructure\Prestashop\PrestashopClient;
use App\Infrastructure\Prestashop\PrestashopProductsPort;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass PrestashopProductsPort
 */
class PrestashopProductsPortTest extends TestCase
{

    private array $productsBeforeSanitization;
    private Product $expectedProduct;

    public function setUp(): void
    {
        $this->productsBeforeSanitization = [
            'products' => [
                [
                    'id' => 'a440f14a-6fb7-4607-b935-a5f4f6bb09a0',
                    'name' => 'Tasty Plastic Keyboard',
                    'description' => 'Amet sequi rem vel consequatur ut cumque qui. Non ut aut esse. Rerum corporis voluptas modi est tene',
                    'link' => 'https://alexandrine.net',
                    'image' => [
                        [
                            'url' => 'http://lorempixel.com/640/480',
                            'alt' => 'Aliquid culpa rerum molestiae ut soluta voluptatem voluptatibus itaque.'
                        ],
                        [
                            'url' => 'http://lorempixel.com/640/480',
                            'alt' => 'Soluta esse velit laborum velit et.'
                        ]
                    ],
                    'availability' => ['stock' => 78],
                    'price' => ['regular' => 49.08989279160331, 'on_sale' => 70.05727532816405],
                    'variations' => [
                        [
                            'id' => 'a83f1d49-3892-4d7f-aa96-ac620e6908f7',
                            'color' => 'olive',
                            'material' => 'Fresh',
                            'updatedAt' => 'Tue Sep 08 2020 03:22:37 GMT+0000 (Coordinated Universal Time)'
                        ],
                        [
                            'id' => '75309ab4-6bcf-4ce7-af39-49ea6f24a5a9',
                            'color' => 'purple',
                            'material' => 'Wooden',
                            'updatedAt' => 'Mon Sep 07 2020 21:27:51 GMT+0000 (Coordinated Universal Time)'
                        ],
                        [
                            'id' => '8ae38276-f0e6-427d-848b-a64febe831fe',
                            'color' => 'olive',
                            'material' => 'Fresh',
                            'updatedAt' => 'Tue Sep 08 2020 03:15:42 GMT+0000 (Coordinated Universal Time)'
                        ],
                    ],
                    'updatedAt' => 'Mon Sep 07 2020 23:48:11 GMT+0000 (Coordinated Universal Time)'
                ]
            ]
        ];

        $availability = new Availability(78);
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
    }

    /**
     * @covers PrestashopProductsPort::findAllProducts
     * @test
     */
    public function findAllProducts()
    {
        $prestashopClientMock = $this->prophesize(PrestashopClient::class);
        $prestashopClientMock->executeOperation()
            ->shouldBeCalledTimes(1)
            ->willReturn($this->productsBeforeSanitization);

        $prestashopProductsPort = new PrestashopProductsPort($prestashopClientMock->reveal());

        $productsSanitized = $prestashopProductsPort->findAllProducts();

        $this->assertEquals($this->expectedProduct, $productsSanitized['products'][0]);
    }
}