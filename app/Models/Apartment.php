<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $table = "apartments";

    protected $fillable = [
        'id',
        'userId',
        'type_propertyId',
        'typeId',
        'countryId',
        'cityId',
        'currencyId',
        'rooms',
        'area',
        'residential_area',
        'kitchen_area',
        'floor',
        'floors',
        'price',
        'description',
        'title'
    ];
}
