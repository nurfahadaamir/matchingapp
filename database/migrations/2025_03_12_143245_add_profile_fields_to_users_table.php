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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('password');
            $table->string('skim')->nullable();
            $table->string('gred')->nullable();
            $table->string('fasiliti')->nullable();
            $table->string('jabatan')->nullable();
            $table->integer('pengalaman')->nullable();
            $table->string('jenis_fasiliti')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_picture', 'skim', 'gred', 'fasiliti', 'jabatan', 'pengalaman', 'jenis_fasiliti']);
        });
    }
};
