<?php

namespace App\Models;

use App\Models\Format;
use App\Models\Provider;
use App\Models\Service;
use App\Models\Type;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'label',
        'type_id',
        'format_id',
        'provider_id'
    ];

    //type relation
    public function type(){
        return $this->belongsTo(Type::class);
    }

    //format relation
    public function format(){
        return $this->belongsTo(Format::class);
    }

    //provider relation
    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    //stock movement
    public function stock_movement(){
        return $this->hasMany(Stock_movement::class);
    }

    //service relation
    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
