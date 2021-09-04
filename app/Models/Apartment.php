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
        'title',
        'name',
        'phone',
        'image'
    ];

    public function country(){
        return $this->hasMany(Country::class,'id', 'countryId');
    }

    public function city(){
        return $this->hasMany(City::class,'id', 'cityId');
    }

    public function currency(){
        return $this->hasMany(Currency::class,'id', 'currencyId');
    }

    public function type(){
        return $this->hasMany(Type::class,'id', 'typeId');
    }

    public function typeproperty(){
        return $this->hasMany(TypeProperty::class,'id', 'type_propertyId');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }
}
