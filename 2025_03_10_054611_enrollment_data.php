<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('EnrollmentData', function (Blueprint $table) {
            $table->id();
            $table->string('Student_Name');
            $table->integer('Age');
            $table->string('Sex');
            $table->string('Address');
            $table->string('Religion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('EnrollmentData');
    }
};
