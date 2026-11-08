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
        Schema::table('users', function(Blueprint $table){
            $table->string('nif')->nullable();
            $table->string('stat')->nullable();
            $table->string('rcs')->nullable();
            $table->string('adress')->nullable();
            $table->string('manager')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('users', ['nif', 'stat', 'rcs', 'adress', 'manager']);
    }
};
