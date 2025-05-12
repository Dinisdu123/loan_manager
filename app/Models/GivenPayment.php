<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GivenPayment extends Model
{
    protected $fillable = ['given_loan_id', 'amount', 'payment_date', 'status'];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function loan()
    {
        return $this->belongsTo(GivenLoan::class, 'given_loan_id');
    }
}