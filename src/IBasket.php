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
    function getItems();

    /**
     * Remove item from basket
     * @param int $id Item ID to remove
     * @param int $count Optional number of items to remove (default 1)
     * @return IItem Removed item
     * @throws ItemNotFoundException
     */
    function removeItem($id, $count = 1);

    /**
     * Remove all items with this Id from the basket
     * @param int $id Item ID to remove
     * @return IItem Removed item
     * @throws ItemNotFoundException
     */
    function removeAllById($id);

    /**
     * Add item to cart
     * @param IItem $item Item to add
     * @return int Number of items in cart
     */
    function addItem(IItem $item);

    /**
     * Increment the count of item in basket by one
     * @param int $id Item ID to increment
     * @throws ItemNotFoundException
     */
    function incrementItem($id);

    /**
     * Decrement the count of item in basket by one
     * @param int $id Item ID to remove
     * @throws ItemNotFoundException
     */
    function decrementItem($id);

    /**
     * Calculate the total value of basket (in cents)
     * @return int
     */
    function calculateTotal();
}
