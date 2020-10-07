<?php

declare(strict_types=1);

namespace App\Tests\Domain\VO;

use App\Domain\VO\Image;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Image
 */
class ImageTest extends TestCase
{

    /**
     * @covers Image::getUrl
     * @covers Image::getAlt
     * @test
     */
    public function getMethods(){
        $image = new Image('http://www.example.com/image.jpg', 'Alternative Text');

        $this->assertEquals('http://www.example.com/image.jpg', $image->getUrl());
        $this->assertEquals('Alternative Text', $image->getAlt());
    }
}