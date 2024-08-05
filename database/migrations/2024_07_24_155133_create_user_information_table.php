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
        Schema::create('user_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('first_name');
            $table->string('father_name');
            $table->string('grandfather_name');
            $table->string('family_name');
            $table->string('nickname')->nullable();
            $table->string('mother_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female']);
            $table->string('address');
            $table->string('nearest_landmark');
            $table->string('phone_number');
            $table->string('driver_phone_number')->nullable();
            $table->string('college');
            $table->string('department');
            $table->string('job_title');
            $table->string('academic_title')->nullable();
            $table->enum('id_type', ['civil_id', 'unified_id']);
            $table->string('civil_or_unified_number');
            $table->date('civil_or_unified_date');
            $table->integer('record')->nullable();
            $table->integer('page')->nullable();
            $table->string('registry_office')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_information');
    }
};
