<?php

declare(strict_types=1);


namespace App\Tests\Application\ApplicationServices;


use App\Application\ApplicationServices\FetchAndSanitizeProducts;
use App\Domain\Aggregate\Product\Product;
use App\Domain\ProductAdapter;
use App\Domain\VO\Availability;
use App\Domain\VO\Image;
use App\Domain\VO\Price;
use App\Domain\VO\Variation;
use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @coversDefaultClass FetchAndSanitizeProducts
 */
class FetchAndSanitizeProductsTest extends TestCase
{

    /** @var Product[] */
    private array $products;
    private Serializer $serializer;

    public function setUp(): void
    {
        $availability = new Availability(10);
        $price = new Price(100, 50);
        $images = [new Image('http://www.example.com/image.jpg', 'Alternative Text')];
        $variationDate = new DateTime('2020-09-07T00:19:09+00:00');
        $variations = [new Variation('1c44946b-b25b-4701-86fe-300f068a79f0', 'Blue', 'Cotton', $variationDate)];
        $updatedAt = new DateTime('2020-09-08T00:19:09+00:00');
        $this->products[] = new Product(
            '908d06af-87cd-4281-915f-b21107948f5d',
            'T-shirt',
            'Beautiful t-shirt',
            'http://www.example.com/t-shirt',
            $availability,
            $price,
            $images,
            $variations,
            $updatedAt
        );

        $encoders = [new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @covers FetchAndSanitizeProducts::execute
     * @test
     */
    public function execute()
    {
        $productAdapterMock = $this->prophesize(ProductAdapter::class);


        $productAdapterMock->findAllProducts()
            ->shouldBeCalledTimes(1)
            ->willReturn(['products' => $this->products]);

        $fetchAndSanitizeProducts = new FetchAndSanitizeProducts($productAdapterMock->reveal(), $this->serializer);

        $jsonProducts = $fetchAndSanitizeProducts->execute();

        $this->assertEquals(
            '{"products":[{"id":"908d06af-87cd-4281-915f-b21107948f5d","name":"T-shirt","description":"Beautiful t-shirt","link":"http:\/\/www.example.com\/t-shirt","availability":{"stock":10},"price":{"regular":100,"onSale":50},"image":[{"url":"http:\/\/www.example.com\/image.jpg","alt":"Alternative Text"}],"variations":[{"id":"1c44946b-b25b-4701-86fe-300f068a79f0","color":"Blue","material":"Cotton","updatedAt":"2020-09-07T00:19:09+00:00"}],"updatedAt":"2020-09-08T00:19:09+00:00"}]}',
            $jsonProducts
        );
    }
}