<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = "units";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name'
    ];
    public function houses(){
        return $this->hasMany(House::class,'unitId', 'id');
    }
}
