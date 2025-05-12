<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGivenPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('given_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('given_loan_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->date('payment_date');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('given_payments');
    }
}