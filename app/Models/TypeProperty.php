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
}
