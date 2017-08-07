<?php

namespace CodeHouse\Cart;

/**
 * Interface for single items in the basket
 *
 * @package CodeHouse\Cart
 */
interface IItem
{
    /**
     * Get item ID
     * @return int
     */
    function getId();

    /**
     * Get item price in cents
     * @return int
     */
    function getPrice();

    /**
     * Number of current items
     * @return int
     */
    function getCount();
}
