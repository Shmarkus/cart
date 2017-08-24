<?php

namespace CodeHouse\Cart\Impl;

use CodeHouse\Cart\Exception\AlreadyInitializedException;
use CodeHouse\Cart\Exception\BasketNotFoundException;
use CodeHouse\Cart\ICart;
use Doctrine\Common\Collections\ArrayCollection;

class Cart implements ICart
{
    /**
     * @var ArrayCollection
     */
    private $_baskets;

    public function __construct()
    {
        $this->_baskets = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    function init($identifier, $type)
    {
        if ($this->_baskets->containsKey($identifier)) {
            throw new AlreadyInitializedException();
        }
        $basket = BasketFactory::getBasket($type);
        $this->_baskets->set($identifier, $basket);
        return $basket;
    }

    /**
     * @inheritdoc
     */
    function get($identifier)
    {
        if (!$this->_baskets->containsKey($identifier)) {
            throw new BasketNotFoundException();
        }
        return $this->_baskets->get($identifier);
    }

    /**
     * @inheritdoc
     */
    function discard($identifier)
    {
        if (!$this->_baskets->containsKey($identifier)) {
            throw new BasketNotFoundException();
        }
        $this->_baskets->remove($identifier);
        return true;
    }
}
