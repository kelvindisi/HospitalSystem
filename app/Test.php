<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $guarded = [];

    // Relationship definition

    public function requested_tests()
    {
        return $this->hasMany('App\RequestedTest');
    }
}
