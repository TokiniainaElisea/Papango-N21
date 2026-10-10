<?php

namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'name'
    ];

    //stock relation
    public function stock(){
        return $this->hasMany(Stock::class);
    }
}
