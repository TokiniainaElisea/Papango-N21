<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'title',
        'name',
        'firstname',
        'adress',
        'phone',
        'town',
        'client_number'
    ];

    //activity relation
    public function activity(){
        return $this->hasMany(Activity::class);
    }
}
