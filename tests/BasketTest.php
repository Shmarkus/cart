<?php

namespace CodeHouse\Cart;

use CodeHouse\Cart\Exception\ItemNotFoundException;
use CodeHouse\Cart\Impl\Item;
use CodeHouse\Cart\Impl\SimpleBasket;

class BasketTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IBasket
     */
    private $_basket;

    public function testShouldReturnEmptyList()
    {
        $this->assertEquals(0, $this->_basket->listItems()->count());
    }

    public function testShouldCalculateTotalOfEmptyBasket()
    {
        $this->assertEquals(0, $this->_basket->calculateTotal());
    }

    public function testShouldGetAddedItem()
    {
        $expectedItem = self::getItem();
        $this->_basket->addItem($expectedItem);
        $this->assertEquals($expectedItem, $this->_basket->listItems()->first());
    }

    public function testShouldIncrementCountByOne()
    {
        $id = 1;
        $count = 2;
        $expectedItem = self::getItem($id, 100, $count);
        $this->_basket->addItem($expectedItem);
        $this->_basket->incrementItem($id);
        $this->assertEquals($count + 1, $this->_basket->listItems()->first()->getCount());
    }

    public function testShouldDecrementCountByOne()
    {
        $id = 1;
        $count = 2;
        $expectedItem = self::getItem($id, 100, $count);
        $this->_basket->addItem($expectedItem);
        $this->_basket->decrementItem($id);
        $this->assertEquals($count - 1, $this->_basket->listItems()->first()->getCount());
    }

    public function testShouldReturnPriceOfOneItem()
    {
        $expectedPrice = 100;
        $this->_basket->addItem(self::getItem(1, $expectedPrice, 1));
        $this->assertEquals($expectedPrice, $this->_basket->calculateTotal());
    }

    public function testShouldListMultipleSameItemsAsOne()
    {
        $count = 5;
        $numberOfUniqueItemsInCart = 1;
        for ($i = 0; $i < $count; $i++) {
            $this->_basket->addItem(self::getItem());
        }
        $this->assertEquals($numberOfUniqueItemsInCart, $this->_basket->listItems()->count());
        $this->assertEquals($count, $this->_basket->listItems()->first()->getCount());
    }

    public function testShouldReturnNumberOfItemsInCart()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->assertEquals($i + 1, $this->_basket->addItem(self::getItem()));
        }
    }

    public function testShouldUseCountInTotalCalculation()
    {
        $count = 40;
        $price = 100;
        for ($i = 0; $i < $count; $i++) {
            $this->_basket->addItem(self::getItem(1, $price));
        }
        $this->assertEquals($count * $price, $this->_basket->calculateTotal());
    }

    public function testShouldCalculateTotalOfMultipleProducts()
    {
        $priceA = 100;
        $priceB = 500;
        $this->_basket->addItem(self::getItem(1, $priceA));
        $this->_basket->addItem(self::getItem(2, $priceB));
        $this->assertEquals($priceA + $priceB, $this->_basket->calculateTotal());
    }

    public function testShouldThrowExceptionWhenNoItemsToRemove()
    {
        try {
            $this->_basket->removeItem(1);
            $this->fail('Should have thrown an exception');
        } catch (ItemNotFoundException $e) {
            $this->assertTrue(true); // ¯\_(ツ)_/¯
        }
    }

    public function testShouldThrowExceptionWhenItemNotInBasket()
    {
        $this->_basket->addItem(self::getItem());
        try {
            $this->_basket->removeItem(2);
            $this->fail('Should have thrown an exception');
        } catch (ItemNotFoundException $e) {
            $this->assertTrue(true); // ¯\_(ツ)_/¯
        }
    }

    public function testShouldRemoveOneItem()
    {
        $this->_removeItems(1);
    }

    public function testShouldRemoveTwoItems()
    {
        $this->_removeItems(2);
    }

    public function testShouldRemoveAllItems()
    {
        $id = 1;
        $count = 3;
        $this->_basket->addItem(self::getItem($id, 100, $count));
        $this->_basket->removeItem($id, $count);
        $this->assertEquals(0, $this->_basket->listItems()->count());
    }

    public function testShouldRemoveAllItemsWhenRemovedMoreThanInTheBasket()
    {
        $id = 1;
        $count = 3;
        $this->_basket->addItem(self::getItem($id, 100, $count));
        $this->_basket->removeItem($id, $count + 1);
        $this->assertEquals(0, $this->_basket->listItems()->count());
    }

    public function testShouldHandleSerialization()
    {
        $item = self::getItem();
        $this->_basket->addItem($item);
        $ser = serialize($this->_basket);
        /**
         * @var $newBasket IBasket
         */
        $newBasket = unserialize($ser);
        $this->assertEquals($item, $newBasket->listItems()->first());
    }

    public function testShouldRemoveAllItemsAtOnce()
    {
        $id = 1;
        $this->_basket->addItem(self::getItem($id, 100, 100));
        $this->_basket->removeAllById($id);
        $this->assertEquals(0, $this->_basket->listItems()->count());
    }

    public function testShouldRemoveAllItemsAtOnceThatDoesntExist()
    {
        $id = 1;
        try {
            $this->_basket->addItem(self::getItem($id, 100, 100));
            $this->_basket->removeAllById(2);
            $this->fail('Should have thrown an exception');
        } catch (ItemNotFoundException $e) {
            $this->assertTrue(true); // ¯\_(ツ)_/¯
        }
    }

    protected function setUp()
    {
        $this->_basket = new SimpleBasket();
    }

    private function _removeItems($itemsToRemove)
    {
        $id = 1;
        $count = 3;
        $this->_basket->addItem(self::getItem($id, 100, $count));
        $this->_basket->removeItem($id, $itemsToRemove);
        $this->assertEquals($count - $itemsToRemove, $this->_basket->listItems()->first()->getCount());
    }

    private static function getItem($id = 1, $price = 100, $count = 1)
    {
        $item = new Item();
        $item->setId($id);
        $item->setPrice($price);
        $item->setCount($count);
        return $item;
    }
}
