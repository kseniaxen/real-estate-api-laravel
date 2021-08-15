<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }
}
