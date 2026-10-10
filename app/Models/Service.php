<?php
namespace App\Models;

use App\Models\ActivityDetail;
use App\Models\Category;
use App\Models\Format;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'label',
        'color',
        'format_id',
        'stock_id',
        'price',
        'category_id',
    ];

    //format relation
    public function format(){
        return $this->belongsTo(Format::class);
    }

    //stock relation
    public function stock(){
        return $this->belongsTo(Stock::class);
    }

    //category relation
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //activity relation
    public function activity()
    {
        return $this->hasMany(ActivityDetail::class);
    }
}
