<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'lender_name', 'amount', 'interest_rate', 'duration_months', 'start_date',
        'total_repayment', 'weekly_repayment', 'remaining_balance', 'status'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}