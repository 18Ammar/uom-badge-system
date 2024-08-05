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
        Schema::create('promote_admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('name');
            $table->string('university_email')->unique();
            $table->string('college_name');
            $table->string('department');
            $table->string('mobile_number');
            $table->string('personal_photo');
            $table->string('authorization_document')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_employee')->default(false);
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
