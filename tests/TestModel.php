<?php

namespace Erashdan\Hashid\Test;

use Erashdan\Hashid\Traits\Hashid;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use Hashid;

    protected $fillable = ['another_key'];

    public $timestamps = false;
}