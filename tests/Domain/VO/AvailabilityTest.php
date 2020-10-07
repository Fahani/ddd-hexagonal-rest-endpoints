<?php

declare(strict_types=1);


namespace App\Tests\Domain\VO;


use App\Domain\VO\Availability;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Availability
 */

class AvailabilityTest extends TestCase
{

    /**
     * @covers Availability::getStock
     * @test
     */
    public function getMethods() {
        $availability = new Availability(-10);
        $this->assertEquals(-10, $availability->getStock());

        $availability = new Availability(0);
        $this->assertEquals(0, $availability->getStock());

        $availability = new Availability(10);
        $this->assertEquals(10, $availability->getStock());
    }


}