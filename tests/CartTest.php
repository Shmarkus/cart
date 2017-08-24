<?php

namespace CodeHouse\Cart;

use CodeHouse\Cart\Exception\AlreadyInitializedException;
use CodeHouse\Cart\Exception\BasketNotFoundException;
use CodeHouse\Cart\Impl\BasketFactory;
use CodeHouse\Cart\Impl\Cart;

class CartTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ICart
     */
    private $_cart;

    public function testShouldInitializeBasket()
    {
        $basket = $this->_cart->init(1, BasketFactory::SIMPLE);
        $this->assertTrue($basket instanceof IBasket);
    }

    public function testShouldThrowExceptionWhenBasketInitialized()
    {
        $id = 1;
        try {
            $this->_cart->init($id, BasketFactory::SIMPLE);
            $this->_cart->init($id, BasketFactory::SIMPLE);
            $this->fail('Should have thrown an exception');
        } catch (AlreadyInitializedException $e) {
            $this->assertTrue(true); // ¯\_(ツ)_/¯
        }
    }

    public function testShouldThrowExceptionWhenGettingUninitializedBasket()
    {
        try {
            $this->_cart->get(1);
            $this->fail('Should have thrown an exception');
        } catch (BasketNotFoundException $e) {
            $this->assertTrue(true); // ¯\_(ツ)_/¯
        }
    }

    public function testShouldReturnBasketById()
    {
        $id = 1;
        $basket = $this->_cart->init($id, BasketFactory::SIMPLE);
        $getBasket = $this->_cart->get($id);
        $this->assertEquals($basket, $getBasket);
    }

    public function testShouldThrowExceptionWhenDiscardingUninitializedBasket()
    {
        try {
            $this->_cart->discard(1);
            $this->fail('Should have thrown an exception');
        } catch (BasketNotFoundException $e) {
            $this->assertTrue(true); // ¯\_(ツ)_/¯
        }
    }

    public function testShouldDiscardBasketById()
    {
        $id = 1;
        try {
            $this->_cart->init($id, BasketFactory::SIMPLE);
            $this->_cart->discard($id);
            $this->_cart->get($id);
            $this->fail('Should have thrown an exception');
        } catch (BasketNotFoundException $e) {
            $this->assertTrue(true); // ¯\_(ツ)_/¯
        }
    }

    public function testShouldHandleSerialization()
    {
        $identifier = 1;
        $basket = $this->_cart->init($identifier, BasketFactory::SIMPLE);
        $ser = serialize($this->_cart);
        /**
         * @var $newCart ICart
         */
        $newCart = unserialize($ser);
        $this->assertEquals($basket, $newCart->get($identifier));
    }

    protected function setUp()
    {
        $this->_cart = new Cart();
    }

}
