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
        Schema::table('dosen', function (Blueprint $table) {
            $table->string('back_title')->nullable()->change();
            $table->string('nidn')->nullable()->after('nip');
            $table->string('no_serdos')->nullable()->after('tanggal_serdos');
            $table->string('jabatan_struktural')->nullable()->after('jabatan');
            $table->string('email')->nullable()->after('kode_dosen');
            $table->string('kontak_wa')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            $table->dropColumn(['nidn', 'no_serdos', 'jabatan_struktural', 'email', 'kontak_wa']);
        });
    }
};
