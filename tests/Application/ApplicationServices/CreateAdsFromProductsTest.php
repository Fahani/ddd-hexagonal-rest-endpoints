<?php

declare(strict_types=1);


namespace App\Tests\Application\ApplicationServices;


use App\Domain\AdsAdapter;
use App\Domain\Aggregate\Ads\Advertisement;
use PHPUnit\Framework\TestCase;
use App\Application\ApplicationServices\CreateAdsFromProducts;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @coversDefaultClass CreateAdsFromProducts
 */
class CreateAdsFromProductsTest extends TestCase
{

    /** @var Advertisement[] */
    private array $adsEnabled;
    /** @var Advertisement[] */
    private array $adsDisabled;
    private Serializer $serializer;

    public function setUp(): void
    {
        $this->adsEnabled[] = new Advertisement(
            '908d06af-87cd-4281-915f-b21107948f5d',
            'T-shirt',
            'https://www.example.com/t-shirt',
            ['https://www.example.com/t-shirt/image.jpg'],
            '10%',
            'New Product!',
            ['Blue', 'Red'],
            ['Cotton', 'Metal']
        );

        $this->adsDisabled[] = new Advertisement(
            '1c44946b-b25b-4701-86fe-300f068a79f0',
            'Jeans',
            'https://www.example.com/jeans',
            ['https://www.example.com/jeans/image.jpg'],
            '50%',
            'Last Units!',
            ['Blue', 'Red'],
            ['Cotton', 'Wood']
        );

        $encoders = [new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @covers CreateAdsFromProducts::execute
     * @test
     */
    public function execute()
    {
        $adsAdapterMock = $this->prophesize(AdsAdapter::class);

        $adsAdapterMock->findAllAds()
            ->shouldBeCalledTimes(1)
            ->willReturn(['advertisements' => ['enabled' => $this->adsEnabled, 'disabled' => $this->adsDisabled]]);

        $createAdsFromProducts = new CreateAdsFromProducts($adsAdapterMock->reveal(), $this->serializer);

        $jsonAds = $createAdsFromProducts->execute();

        $this->assertEquals(
            '{"advertisements":{"enabled":[{"id":"908d06af-87cd-4281-915f-b21107948f5d","name":"T-shirt","images":["https:\/\/www.example.com\/t-shirt\/image.jpg"],"discount":"10%","message":"New Product!","colors":["Blue","Red"],"materials":["Cotton","Metal"],"link":"https:\/\/www.example.com\/t-shirt"}],"disabled":[{"id":"1c44946b-b25b-4701-86fe-300f068a79f0","name":"Jeans","images":["https:\/\/www.example.com\/jeans\/image.jpg"],"discount":"50%","message":"Last Units!","colors":["Blue","Red"],"materials":["Cotton","Wood"],"link":"https:\/\/www.example.com\/jeans"}]}}',
            $jsonAds
        );
    }
}