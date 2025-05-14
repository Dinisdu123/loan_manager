<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddOverduePaidToGivenPaymentsStatus extends Migration
{
    public function up()
    {
        // Change the ENUM to include 'overdue_paid'
        DB::statement("ALTER TABLE given_payments MODIFY COLUMN status ENUM('pending', 'paid', 'overdue_paid') DEFAULT 'pending'");
    }

    public function down()
    {
        // Revert the ENUM to exclude 'overdue_paid'
        DB::statement("ALTER TABLE given_payments MODIFY COLUMN status ENUM('pending', 'paid') DEFAULT 'pending'");
        // Optionally, reset any 'overdue_paid' statuses to 'paid'
        DB::table('given_payments')->where('status', 'overdue_paid')->update(['status' => 'paid']);
    }
}