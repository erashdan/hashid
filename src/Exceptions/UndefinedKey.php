<?php

namespace Erashdan\Hashid\Exceptions;

use Exception;

class UndefinedKey extends Exception
{
    protected $message = 'Unable to define hashing key';
}
