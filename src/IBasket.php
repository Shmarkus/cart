<?php

namespace CodeHouse\Cart;

use CodeHouse\Cart\Exception\ItemNotFoundException;

/**
 * Interface for basket. This is a collection wrapper for IItem
 *
 * @package CodeHouse\Cart
 */
interface IBasket
{
    /**
     * Return the list of items in basket
     * @return \Doctrine\Common\Collections\Collection
     */
    function listItems();

    /**
     * Remove item from basket
     * @param int $id Item ID to remove
     * @param int $count Optional number of items to remove (default 1)
     * @return IItem Removed item
     * @throws ItemNotFoundException
     */
    function removeItem($id, $count = 1);

    /**
     * Add item to cart
     * @param IItem $item Item to add
     * @return int Number of items in cart
     */
    function addItem(IItem $item);

    /**
     * Calculate the total value of basket (in cents)
     * @return int
     */
    function calculateTotal();
}
