<?php

namespace CodeHouse\Cart;

use CodeHouse\Cart\Exception\AlreadyInitializedException;
use CodeHouse\Cart\Exception\BasketNotFoundException;

/**
 * Interface ICart is a wrapper for baskets. Use this to access users baskets
 *
 * @package CodeHouse\Cart
 */
interface ICart
{
    /**
     * Initialize basket. Must be invoked, before basket can be used
     * @param string $identifier Session ID or other identifier for basket
     * @return IBasket
     * @throws AlreadyInitializedException
     */
    function init($identifier);

    /**
     * Get specific basket
     * @param string $identifier Session ID or other identifier for basket
     * @return IBasket
     * @throws BasketNotFoundException
     */
    function get($identifier);

    /**
     * Throw basket away
     * @param string $identifier Session ID or other identifier for basket
     * @return boolean Whether a basket was discarded
     * @throws BasketNotFoundException
     */
    function discard($identifier);
}
