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
    Schema::table('user_matches', function (Blueprint $table) {
        $table->string('penyelia_name')->nullable()->after('matched_user_id');
        $table->string('penyelia_email')->nullable()->after('penyelia_name');
        $table->string('penyelia_phone')->nullable()->after('penyelia_email');
        $table->string('ketua_jabatan_name')->nullable()->after('penyelia_phone');
        $table->string('ketua_jabatan_email')->nullable()->after('ketua_jabatan_name');
        $table->string('ketua_jabatan_phone')->nullable()->after('ketua_jabatan_email');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_matches', function (Blueprint $table) {
            //
        });
    }
};
