<?php

namespace CodeHouse\Cart\Impl;

use CodeHouse\Cart\IItem;

class Item implements IItem
{
    /**
     * @var int Item ID
     */
    private $_id;
    /**
     * @var int Item price in cents
     */
    private $_price;
    /**
     * @var int Item count
     */
    private $_count = 1;

    /**
     * Get item ID
     * @return int
     */
    function getId()
    {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * Get item price in cents
     * @return int
     */
    function getPrice()
    {
        return $this->_price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->_price = $price;
    }

    /**
     * Number of current items
     * @return int
     */
    function getCount()
    {
        return $this->_count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->_count = $count;
    }
}
