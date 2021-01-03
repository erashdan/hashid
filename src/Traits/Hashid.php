<?php

namespace Erashdan\Hashid\Traits;

use Erashdan\Hashid\Exceptions\UndefinedKey;
use Erashdan\Hashid\HashData;
use Illuminate\Database\Eloquent\Model;
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

    //  ----------    Scope    ----------

    /**
     * Find or fail by hash ID.
     *
     * @param $query
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function scopeFindOrFailHashed($query, $id)
    {
        if (empty($decoded = self::DecodeId($id))) {
            throw new ModelNotFoundException('Unable to find element', 404);
        }

        return $query->findOrFail(self::DecodeId($id));
    }

    /**
     * Find resource by hashed id.
     *
     * @param $id
     * @return null|Model
     * @throws \Exception
     */
    public static function FindHashed($id)
    {
        if (empty($decoded = self::DecodeId($id))) {
            return null;
        }

        return self::find(self::DecodeId($id));
    }

    /**
     * Find multiple resources by hash ids.
     *
     * @param $query
     * @param array $values
     * @return mixed
     * @throws \Exception
     */
    public function scopeWhereInHashed($query, array $values)
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
            throw new UndefinedKey();
        }

        return config('hashid.hash_data.key').$class;
    }
}
