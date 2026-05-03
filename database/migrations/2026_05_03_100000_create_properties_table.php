<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('operation_type', 20);
            $table->string('property_type', 30);
            $table->decimal('price', 14, 2);
            $table->string('currency', 3)->default('USD');
            $table->unsignedInteger('bedrooms')->nullable();
            $table->unsignedInteger('bathrooms')->nullable();
            $table->decimal('area_m2', 10, 2)->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['is_featured', 'is_published']);
            $table->index(['operation_type', 'property_type']);
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
