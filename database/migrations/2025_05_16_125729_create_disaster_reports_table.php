<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
     Schema::create('disaster_reports', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('disaster_id'); // links to earthquake or wind
        $table->enum('disaster_type', ['earthquake', 'wind']);
        $table->date('date');
        $table->string('location');
        $table->enum('damage_status', [
            'Minimal', 'Moderate', 'Severe', 'Worst', 'Catastrophic']);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disaster_reports');
    }
};
