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
        Schema::create('user_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('driver_photo'); 
            $table->string ('applicant_photo');
            $table->string ('civil_or_unified_id_front'); 
            $table->string('civil_or_unified_id_back');
            $table->string('iraqi_nationality')->nullable();
            $table->string('ration_card');
            $table->string('green_card_front');
            $table->string('green_card_back');
            $table->string('residence_certification');
            $table->string('continuous_service_letter');
            $table->string('university_id_front');
            $table->string('university_id_back');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_images');
    }
};
