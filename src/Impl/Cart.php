<?php

namespace CodeHouse\Cart\Impl;

use CodeHouse\Cart\Exception\AlreadyInitializedException;
use CodeHouse\Cart\Exception\BasketNotFoundException;
use CodeHouse\Cart\IBasket;
use CodeHouse\Cart\ICart;
use Doctrine\Common\Collections\ArrayCollection;

class Cart implements ICart
{
    /**
     * @var ArrayCollection
     */
    private $_carts;

    public function __construct()
    {
        $this->_carts = new ArrayCollection();
    }

    /**
     * Initialize basket. Must be invoked, before basket can be used
     * @param string $identifier Session ID or other identifier for basket
     * @return IBasket
     * @throws AlreadyInitializedException
     */
    function init($identifier)
    {
        if ($this->_carts->containsKey($identifier)) {
            throw new AlreadyInitializedException();
        }
        $basket = new SimpleBasket();
        $this->_carts->set($identifier, $basket);
        return $basket;
    }

    /**
     * Get specific basket
     * @param string $identifier Session ID or other identifier for basket
     * @return IBasket
     * @throws BasketNotFoundException
     */
    function get($identifier)
    {
        if (!$this->_carts->containsKey($identifier)) {
            throw new BasketNotFoundException();
        }
        return $this->_carts->get($identifier);
    }

    /**
     * Throw basket away
     * @param string $identifier Session ID or other identifier for basket
     * @return boolean Whether a basket was discarded
     * @throws BasketNotFoundException
     */
    function discard($identifier)
    {
        if (!$this->_carts->containsKey($identifier)) {
            throw new BasketNotFoundException();
        }
        $this->_carts->remove($identifier);
        return true;
    }
}
