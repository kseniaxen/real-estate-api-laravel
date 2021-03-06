<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "cities";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'countryId'
    ];
    public function apartments(){
        return $this->hasMany(Apartment::class,'cityId', 'id');
    }
    public function houses(){
        return $this->hasMany(House::class,'cityId', 'id');
    }
}
