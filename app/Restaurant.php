<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'title', 'address', 'zipcode', 'city', 'phone', 'email', 'user_id' ,
    ];

    public function orders()
    {
    	return $this->hasMany('App\Order');
    }

    public function consumables()
    {
    	return $this->hasMany('App\Consumable');
    }

    public function owner()
    {
    	return $this->belongsTo('App\User');
    }

    public function openingtimes()
    {
        return $this->hasOne('App\openingtime');
    }
}
