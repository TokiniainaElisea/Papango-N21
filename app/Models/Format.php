<?php
namespace App\Models;

use App\Models\Service;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $fillable = [
        'name',
        'dimension',
    ];

    //stock relation
    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    //service relation
    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
