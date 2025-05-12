<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'nic',
        'phone',
        'address',
        'user_number', 
    ];

    
}