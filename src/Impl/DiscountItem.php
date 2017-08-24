<?php
namespace CodeHouse\Cart\Impl;

use CodeHouse\Cart\IItem;

class DiscountItem extends Item implements IItem
{
    /**
     * @var int discount percent
     */
    private $_discount;

    /**
     * @return int
     */
    public function getDiscount()
    {
        return $this->_discount;
    }

    /**
     * @param int $discount
     */
    public function setDiscount($discount)
    {
        $this->_discount = $discount;
    }
}
