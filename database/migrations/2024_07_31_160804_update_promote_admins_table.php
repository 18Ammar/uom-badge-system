<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('promote_admins', function (Blueprint $table) {
            $table->string('authorization_document')->nullable()->change();
            $table->dropColumn(['is_admin', 'is_employee']);
            $table->enum('employee_type', ['authorize', 'admin']);
        });
    }

    public function down()
    {
        Schema::table('promote_admins', function (Blueprint $table) {
            $table->string('authorization_document')->nullable()->change();

            $table->dropColumn('employee_type');

            $table->boolean('is_admin')->default(false);
            $table->boolean('is_employee')->default(false);
        });
    }
};
