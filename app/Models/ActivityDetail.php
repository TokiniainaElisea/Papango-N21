<?php
namespace App\Models;

use App\Models\Activity;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;

class ActivityDetail extends Model
{
    protected $fillable = [
        'activity_id',
        'service_id',
        'service_label',
        'unit_price',
        'cost_price',
        'quantity',
        'discount',
        'total_line',
    ];

    //activity relation
    public function activity(){
        return $this->belongsTo(Activity::class);
    }

    //service relation
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
