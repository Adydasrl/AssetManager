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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('codifica dispositivo');
            $table->string('tipo dispositivo');
            $table->foreignId('customer_id')->nullable()->constrained();
            $table->string('serial number');
            $table->enum('type', ['interno', 'cliente']);
            $table->string('owner_name')->nullable();
            //$table->string('status');
            //$table->date('data_assigned')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
