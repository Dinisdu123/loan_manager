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
    public function centers()
    {
        return $this->belongsToMany(Center::class);
    }

    // Define relationship with given loans
    public function given_loans()
    {
        return $this->hasMany(GivenLoan::class);
    }
    
}