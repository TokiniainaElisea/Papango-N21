<?php
namespace App\Models;

use App\Models\ActivityDetail;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'ref',
        'client_id',
        'total_price',
        'payment_method',
        'note',
    ];

    //client relation
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    //activity relation
    public function details()
    {
        return $this->hasMany(ActivityDetail::class);
    }

}
