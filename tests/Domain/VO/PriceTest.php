<?php

declare(strict_types=1);

namespace App\Tests\Domain\VO;

use App\Domain\VO\Price;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Price
 */
class PriceTest extends TestCase
{
    /**
     * @covers Price::getRegular
     * @covers Price::getOnSale
     * @test
     */
    public function getMethods() {
        $price = new Price(60.5, 10);

        $this->assertEquals(60.5, $price->getRegular());
        $this->assertEquals(10, $price->getOnSale());
    }

}