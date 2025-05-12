<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('lender_name');
            $table->decimal('amount', 15, 2);
            $table->decimal('interest_rate', 5, 2); // e.g., 3.00 for 3%
            $table->integer('duration_months');
            $table->date('start_date');
            $table->decimal('total_repayment', 15, 2);
            $table->decimal('weekly_repayment', 15, 2);
            $table->decimal('remaining_balance', 15, 2);
            $table->string('status')->default('active'); // active, paid, overdue
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loans');
    }
}