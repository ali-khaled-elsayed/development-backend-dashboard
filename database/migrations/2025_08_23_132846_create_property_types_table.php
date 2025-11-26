<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use app\Modules\Shared\Enums\UnitTypeEnum;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('property_types', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->enum('type', UnitTypeEnum::values())->nullable();
            $table->integer('area_min');
            $table->integer('area_max');
            $table->integer('price_min');
            $table->integer('price_max');
            $table->integer('no_of_bedrooms_min')->default(0);
            $table->integer('no_of_bedrooms_max')->default(0);
            $table->integer('no_of_bathrooms_min')->default(0);
            $table->integer('no_of_bathrooms_max')->default(0);

            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_types');
    }
};
