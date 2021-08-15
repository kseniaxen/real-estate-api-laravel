<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $table = "houses";

    protected $fillable = [
        'id',
        'userId',
        'type_propertyId',
        'typeId',
        'countryId',
        'cityId',
        'currencyId',
        'unitId',
        'rooms',
        'area',
        'residential_area',
        'kitchen_area',
        'land_area',
        'floors',
        'price',
        'description',
        'title',
        'image'
    ];

    public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }
}
