<?php

namespace CodeHouse\Cart\Exception;

use Throwable;

class BasketNotFoundException extends \Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct("Basket not found", 200, $previous);
    }
}
