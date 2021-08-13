<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = "currencies";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name'
    ];
    public function apartments(){
        return $this->hasMany(Apartment::class,'currencyId', 'id');
    }
}
