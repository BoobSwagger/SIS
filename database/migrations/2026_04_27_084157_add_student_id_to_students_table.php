<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('student_id')->unique()->after('id');
            // We also need to add Gender back since we used it in the dashboard
            if (!Schema::hasColumn('students', 'gender')) {
                $table->string('gender')->after('course')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('student_id');
            $table->dropColumn('gender');
        });
    }
};