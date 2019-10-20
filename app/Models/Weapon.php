<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'name',
        'description'
    ];
}
