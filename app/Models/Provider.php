<?php
namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'name_provider',
        'mail',
        'phone',
        'adress',
        'town',
        'country',
        'name_contact',
        'note',
    ];

    //stock relation
    public function stock(){
        return $this->hasMany(Stock::class);
    }
}
