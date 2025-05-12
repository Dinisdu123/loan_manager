<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentersTable extends Migration
{
    public function up()
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nickname')->unique(); // Nickname for the center
            $table->foreignId('leader_id')->nullable()->constrained('users')->onDelete('set null'); // Leader is a user
            $table->timestamps();
        });

        // Pivot table for center-user relationship (many-to-many for members)
        Schema::create('center_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('center_user');
        Schema::dropIfExists('centers');
    }
}