<?php

namespace CodeHouse\Cart\Impl;

use CodeHouse\Cart\IBasket;

class DiscountBasket extends SimpleBasket implements IBasket
{
    /**
     * @inheritdoc
     */
    function calculateTotal()
    {
        $total = 0;
        foreach ($this->_items->getIterator() as $item) {
            $discount = ($item->getPrice() / 100) * $item->getDiscount();
            $total += ($item->getPrice() - $discount) * $item->getCount();
        }
        return $total;
    }
}
