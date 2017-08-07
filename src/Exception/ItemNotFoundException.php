<?php

namespace CodeHouse\Cart\Exception;

use Throwable;

class ItemNotFoundException extends \Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct("Item not found", 200, $previous);
    }
}
