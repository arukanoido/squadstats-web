<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'name',
        'abbreviation',
        'description'
    ];
}
