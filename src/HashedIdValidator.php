<?php

namespace Erashdan\Hashid;

class HashedIdValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        if (!isset($parameters[0])) {
            return false;
        }

        return $parameters[0]::FindHashed($value) !== null;
    }
}
