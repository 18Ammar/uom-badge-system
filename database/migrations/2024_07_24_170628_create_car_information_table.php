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
        Schema::create('car_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('car_number');
            $table->string('ownership');
            $table->string('car_type');
            $table->string('car_color');
            $table->string('car_model');
            $table->string('agency_1');
            $table->string('agency_2');
            $table->string('driving_license_face');
            $table->string('driving_license_back');
            $table->string('car_registration_face');
            $table->string('car_registration_back');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_information');
    }
};
