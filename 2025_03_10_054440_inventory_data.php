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
        Schema::create('InventoryData', function (Blueprint $table) {
            $table->id();
            $table->string('Fund_Year');
            $table->string('Category');
            $table->string('Serial_Number');
            $table->string('Location');
            $table->integer('Cost_Of_Equipment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('InventoryData');
    }
};
