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
        Schema::create('WorkmanData', function (Blueprint $table) {
            $table->id();
            $table->string('Worker_Name');
            $table->string('Position');
            $table->string('Contact_Number');
            $table->string('Email');
            $table->string('Registration_Number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('WorkmanData');
    }
};
