<?php

namespace CodeHouse\Cart\Exception;

use Throwable;

class AlreadyInitializedException extends \Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct("Cart already initialized", 100, $previous);
    }
}
