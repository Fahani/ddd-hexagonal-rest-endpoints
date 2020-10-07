<?php

declare(strict_types=1);

namespace App\Tests\Domain\VO;

use PHPUnit\Framework\TestCase;
use App\Domain\VO\Variation;
use Ramsey\Uuid\Uuid;
use DateTime;

/**
 * @coversDefaultClass Variation
 */
class VariationTest extends TestCase
{

    /**
     * @covers Variation::getMaterial
     * @covers Variation::getColor
     * @covers Variation::getId
     * @covers Variation::getUpdatedAt
     * @test
     */
    public function getMethods() {
        $id = Uuid::uuid4()->toString();
        $date = new DateTime('2020-09-07T00:19:09+00:00');
        $variation = new Variation($id, 'White', 'Cotton', $date);

        $this->assertEquals($id, $variation->getId());
        $this->assertEquals('White', $variation->getColor());
        $this->assertEquals('Cotton', $variation->getMaterial());
        $this->assertEquals($date, $variation->getUpdatedAt());
    }
}