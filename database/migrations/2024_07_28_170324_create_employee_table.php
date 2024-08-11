<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //this table for adding employees and to promote employees to admin or authorizer
    public function up(): void
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('name');
            $table->string('university_email')->unique();
            $table->string('college_name');
            $table->string('department');
            $table->string('mobile_number');
            $table->string('personal_photo');
            $table->string('authorization_document')->nullable();
            $table->enum('employee_type', ['authorize', 'admin']);
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promote_admins');
    }
};
