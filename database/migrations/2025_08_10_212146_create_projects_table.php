<?php

use App\Modules\Project\Enums\FinishingTypeEnum;
use App\Modules\Project\Enums\ProjectTypeEnum;
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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('description_en')->nullable();
            $table->string('description_ar')->nullable();
            $table->string('short_description_en')->nullable();
            $table->string('short_description_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->string('meta_title_ar')->nullable();
            $table->string('meta_description_en')->nullable();
            $table->string('meta_description_ar')->nullable();
            $table->integer('project_area');
            $table->string('location')->nullable();
            $table->string('master_plan')->nullable();
            $table->string('logo')->nullable();
            $table->string('video_link')->nullable();
            $table->date('delivery_date')->nullable();
            $table->json('payment_plan')->nullable();

            $table->enum('type', ProjectTypeEnum::values())->nullable();
            $table->enum('finishing_type', FinishingTypeEnum::values())->nullable();

            $table->foreignId('city_id')->constrained('cities');
            $table->foreignId('area_id')->constrained('areas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
