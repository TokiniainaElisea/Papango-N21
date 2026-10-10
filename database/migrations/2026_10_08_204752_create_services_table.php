<?php

use App\Models\Category;
use App\Models\Format;
use App\Models\Stock;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable();
            $table->string('color')->nullable();
            $table->foreignIdFor(Format::class)->nullOnDelete();
            $table->foreignIdFor(Stock::class)->nullOnDelete();
            $table->double('price')->nullable();
            $table->foreignIdFor(Category::class)->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
