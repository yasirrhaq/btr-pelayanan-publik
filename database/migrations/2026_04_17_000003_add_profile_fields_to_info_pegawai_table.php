<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('info_pegawai', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('title');
            $table->string('jenis_kepegawaian')->nullable()->after('nip');
            $table->string('pangkat_golongan')->nullable()->after('jenis_kepegawaian');
            $table->string('jabatan')->nullable()->after('pangkat_golongan');
            $table->string('instansi')->nullable()->after('jabatan');
            $table->string('email')->nullable()->after('instansi');
        });
    }

    public function down()
    {
        Schema::table('info_pegawai', function (Blueprint $table) {
            $table->dropColumn([
                'nip',
                'jenis_kepegawaian',
                'pangkat_golongan',
                'jabatan',
                'instansi',
                'email',
            ]);
        });
    }
};
