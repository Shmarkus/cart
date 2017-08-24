<?php

namespace CodeHouse\Cart;

use CodeHouse\Cart\Impl\DiscountItem;

class DiscountItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DiscountItem
     */
    private $_item;

    public function testShouldReturnDiscountedPrice()
    {
        $price = 31250;
        $discount = 39.0;
        $expected = 19062.5;
        $this->_item->setPrice($price);
        $this->_item->setDiscount($discount);
        $this->assertEquals($expected, $this->_item->getPrice());
    }

    protected function setUp()
    {
        $this->_item = new DiscountItem();
    }

}
