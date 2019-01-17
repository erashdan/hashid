<?php

namespace Erashdan\Hashid;

use Hashids\Hashids;

class HashData
{
    /**
     * Encode ID.
     *
     * @param $key
     * @param null $baseKey
     * @return mixed
     * @throws \Exception
     */
    public static function Encode($key, $baseKey)
    {
        $hashids = new Hashids($baseKey, self::getLength());

        return $hashids->encode($key);
    }

    /**
     * Decode ID.
     *
     * @param $key
     * @param null $baseKey
     * @return mixed
     * @throws \Exception
     */
    public static function Decode($key, $baseKey = null)
    {
        if (! $baseKey) {
            $baseKey = self::getKey();
        }

        $hashids = new Hashids($baseKey, self::getLength());

        return $hashids->decode($key);
    }

    /**
     * Get length.
     *
     * @throws \Exception
     * @return int
     */
    private static function getLength(): int
    {
        if (
            (config('hashid.hash_data.length') == null) ||
            (config('hashid.hash_data.length') == '') ||
            ! is_int(config('hashid.hash_data.length'))
        ) {
            throw new \Exception('Unable to define hashing length');
        }

        return config('hashid.hash_data.length');
    }
}
