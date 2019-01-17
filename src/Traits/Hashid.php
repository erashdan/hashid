<?php

namespace Erashdan\Hashid\Traits;

use Erashdan\Hashid\HashData;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait Hashid
{
    /**
     * Encode hashed id.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getHashedIdAttribute()
    {
        $primary = $this->primaryKey;

        return HashData::Encode($this->$primary, self::setHashKey(self::class), 20);
    }

    /**
     * Decode hash id.
     *
     * @param $id
     * @return |null
     * @throws \Exception
     */
    public static function DecodeId($id)
    {
        $decode = HashData::Decode($id, self::setHashKey(self::class), 20);

        if (count($decode) > 0) {
            return $decode[0];
        }
    }

    public function scopeFindOrFailHashed($query, $id)
    {
        if (empty($decoded = self::DecodeId($id))) {
            throw new ModelNotFoundException('Unable to find element', 404);
        }

        return $query->findOrFail(self::DecodeId($id));
    }

    public function scopeFindHashed($query, $id)
    {
        if (empty($decoded = self::DecodeId($id))) {
            return;
        }

        return $query->find(self::DecodeId($id));
    }

    public function scopeWhereInHashed($query, $values)
    {
        $hash = [];
        foreach ($values as $value) {
            $hash[] = self::DecodeId($value);
        }

        return $query->whereIn($this->primaryKey, $hash);
    }

    private static function setHashKey($class)
    {
        if (
            (config('hashid.hash_data.key') == null) ||
            (config('hashid.hash_data.key') == '')
        ) {
            throw new \Exception('Unable to define hashing key');
        }

        return config('hashid.hash_data.key').$class;
    }
}
