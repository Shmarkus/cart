<?php

namespace CodeHouse\Cart;

use CodeHouse\Cart\Impl\DiscountBasket;
use CodeHouse\Cart\Impl\DiscountItem;

class DiscountBasketTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IBasket
     */
    private $_basket;

    public function testShouldReturnDiscountedPrice()
    {
        $price = 31250;
        $discount = 39.0;
        $expected = 19062.5;
        $item = self::getItem(1, $price, $discount);
        $this->_basket->addItem($item);
        $this->assertEquals($expected, $this->_basket->calculateTotal());
    }

    protected function setUp()
    {
        $this->_basket = new DiscountBasket();
    }

    private static function getItem($id = 1, $price = 100, $discount = 10, $count = 1)
    {
        $item = new DiscountItem();
        $item->setId($id);
        $item->setPrice($price);
        $item->setCount($count);
        $item->setDiscount($discount);
        return $item;
    }
}
