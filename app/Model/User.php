<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    public function orders()
    {
        return $this->hasMany('App\Model\Order', 'user_id');
    }
}
