<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();

            $table->decimal('price', 12, 2)->nullable();

            $table->string('brand');
            $table->string('model');
            $table->string('version')->nullable();

            $table->unsignedSmallInteger('year');
            $table->unsignedSmallInteger('model_year')->nullable();

            $table->unsignedInteger('mileage_km')->nullable();

            $table->string('fuel')->nullable();
            $table->string('transmission')->nullable();
            $table->string('color')->nullable();

            $table->string('status')->default('available'); // available | sold | hidden
            $table->boolean('featured')->default(false);

            $table->string('whatsapp_phone')->nullable(); // opcional por veículo
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'featured']);
            $table->index(['brand', 'model', 'year']);
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
