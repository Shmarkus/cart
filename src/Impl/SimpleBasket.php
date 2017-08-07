<?php

namespace CodeHouse\Cart\Impl;

use CodeHouse\Cart\Exception\ItemNotFoundException;
use CodeHouse\Cart\IBasket;
use CodeHouse\Cart\IItem;
use Doctrine\Common\Collections\ArrayCollection;

class SimpleBasket implements IBasket
{
    /**
     * @var ArrayCollection Items in basket
     */
    private $_items;

    public function __construct()
    {
        $this->_items = new ArrayCollection();
    }

    /**
     * Return the list of items in basket
     * @return \Doctrine\Common\Collections\Collection
     */
    function listItems()
    {
        return $this->_items;
    }

    /**
     * Remove item from basket
     * @param int $id Item ID to remove
     * @param int $count Optional number of items to remove (default 1)
     * @return IItem Removed item
     * @throws ItemNotFoundException
     */
    function removeItem($id, $count = 1)
    {
        $existing = $this->_items->filter(function (IItem $i) use ($id) {
            return $i->getId() === $id;
        });
        if ($existing->count() == 0) {
            throw new ItemNotFoundException();
        } else {
            $first = $existing->first();
            $c = $first->getCount() - $count;
            if ($c > 0) {
                $first->setCount($c);
            } else {
                $this->_items->removeElement($first);
            }
        }
        return $first;
    }

    /**
     * Add item to cart
     * @param IItem $item Item to add
     * @return int Number of items in cart
     */
    function addItem(IItem $item)
    {
        $id = $item->getId();
        $count = $item->getCount();
        // Increment count if item is already in cart
        $existing = $this->_items->filter(function (IItem $i) use ($id) {
            return $i->getId() === $id;
        });
        if ($existing->count() > 0) {
            $first = $existing->first();
            $count = $first->getCount() + $item->getCount();
            $first->setCount($count);
        } else {
            $this->_items->add($item);
        }
        return $count;
    }

    /**
     * Calculate the total value of basket (in cents)
     * @return int
     */
    function calculateTotal()
    {
        $total = 0;
        foreach ($this->_items->getIterator() as $item) {
            $total += $item->getPrice() * $item->getCount();
        }
        return $total;
    }
}
