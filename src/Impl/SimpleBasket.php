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
     * @inheritdoc
     */
    function listItems()
    {
        return $this->_items;
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
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
     * @inheritdoc
     */
    function calculateTotal()
    {
        $total = 0;
        foreach ($this->_items->getIterator() as $item) {
            $total += $item->getPrice() * $item->getCount();
        }
        return $total;
    }

    /**
     * @inheritdoc
     */
    function removeAllById($id)
    {
        $existing = $this->_items->filter(function (IItem $i) use ($id) {
            return $i->getId() === $id;
        });
        if ($existing->count() > 0) {
            $first = $existing->first();
            $this->_items->removeElement($first);
        } else {
            throw new ItemNotFoundException();
        }

        return $existing;
    }

    /**
     * @inheritdoc
     */
    function incrementItem($id)
    {
        $existing = $this->_items->filter(function (IItem $i) use ($id) {
            return $i->getId() === $id;
        });
        if ($existing->count() > 0) {
            $first = $existing->first();
            $first->setCount($first->getCount() + 1);
        } else {
            throw new ItemNotFoundException();
        }
    }

    /**
     * @inheritdoc
     */
    function decrementItem($id)
    {
        $existing = $this->_items->filter(function (IItem $i) use ($id) {
            return $i->getId() === $id;
        });
        if ($existing->count() > 0) {
            $first = $existing->first();
            // removing last item?
            if ($first->getCount() == 1) {
                $this->_items->removeElement($first);
            } else {
                $first->setCount($first->getCount() - 1);
            }
        } else {
            throw new ItemNotFoundException();
        }
    }

}
