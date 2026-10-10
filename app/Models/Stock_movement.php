<?php
namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;

class Stock_movement extends Model
{
    protected $fillable = [
        'stock_id',
        'movement_type',
        'initial_stock',
        'in_stock',
        'provider_price',
        'entry_stock',
    ];

    //stock relation
    public function stock(){
        return $this->belongsTo(Stock::class);
    }
}
