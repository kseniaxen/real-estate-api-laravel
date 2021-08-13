<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = "types";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name'
    ];
    public function apartments(){
        return $this->hasMany(Apartment::class,'typeId', 'id');
    }
}
