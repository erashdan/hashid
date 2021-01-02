<?php

namespace Erashdan\Hashid\Exceptions;

use Exception;

class UndefinedLength extends Exception
{
    protected $message = 'Unable to define hashing length';
}
