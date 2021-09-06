<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeProperty extends Model
{
    protected $table = "type_properties";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name'
    ];
    public function apartments(){
        return $this->hasMany(Apartment::class,'type_propertyId', 'id');
    }
    public function houses(){
        return $this->hasMany(House::class,'type_propertyId', 'id');
    }
}
