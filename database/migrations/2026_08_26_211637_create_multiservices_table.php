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
        Schema::create('multiservices', function (Blueprint $table) {
            $table->id();
            $table->string('service_name'); //Photocopie noir et blanc
            $table->string('service_color'); //Noir et blanc
            $table->string('service_format'); //A3
            $table->double('service_price'); //100 Ar
                                                //papier bristol
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multiservices');
    }
};
