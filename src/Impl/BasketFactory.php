<?php

namespace CodeHouse\Cart\Impl;

use CodeHouse\Cart\Exception\BasketNotFoundException;
use CodeHouse\Cart\IBasket;

class BasketFactory
{
    const SIMPLE = 'simple';
    const DISCOUNT = 'discount';

    /**
     * Return basket by type. See class constants for different types
     * @param $type
     * @return IBasket
     * @throws BasketNotFoundException
     */
    public static function getBasket($type)
    {
        $basket = null;
        switch ($type) {
            case self::SIMPLE:
                $basket = new SimpleBasket();
                break;
            case self::DISCOUNT:
                $basket = new DiscountBasket();
                break;
            default:
                throw new BasketNotFoundException($type);
                break;
        }
        return $basket;
    }
}
