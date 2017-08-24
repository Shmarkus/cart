<?php
namespace CodeHouse\Cart\Impl;

use CodeHouse\Cart\IItem;

class DiscountItem extends Item implements IItem
{
    /**
     * @var int Item original price
     */
    private $_originalPrice;

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

    public function getPrice()
    {
        $discount = (parent::getPrice() / 100) * $this->getDiscount();
        return parent::getPrice() - $discount;
    }

    /**
     * @return int
     */
    public function getOriginalPrice()
    {
        return $this->_originalPrice;
    }

    /**
     * @param int $originalPrice
     */
    public function setOriginalPrice($originalPrice)
    {
        $this->_originalPrice = $originalPrice;
    }
}
