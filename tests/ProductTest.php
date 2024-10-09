<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;

class ProductTest extends TestCase
{
    /**
     * @dataProvider provideProdFood
     */
    public function testSomething($expect,$entry): void
    {
        $product = new Product('bonbon','food',$entry);
        $this->assertSame($expect,$product->computeTVA());
        $this->expectException('Exception');
        $product->sendException();
    }

    public function provideProdFood() {
        return [
            [10,10],
            [20,20]
        ];
    }
}
