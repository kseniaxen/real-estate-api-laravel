<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = "countries";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name'
    ];
    public function apartments(){
        return $this->hasMany(Apartment::class,'countryId', 'id');
    }
    public function houses(){
        return $this->hasMany(House::class,'countryId', 'id');
    }
}
