<?php

use App\Models\FooterSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $map_footer_setting = [
            'alamat' => 'Jl. Gatot Subroto No. 6, Kebun Bunga, Kec. Banjarmasin Timur Kota Banjarmasin, Kalimantan Selatan 70235',
            'no_hp' => '0511 - 3256623',
            'email' => 'baltekrawa@pu.go.id'
        ];

        FooterSetting::insert($map_footer_setting);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('footer_settings', function (Blueprint $table) {
            //
        });
    }
};
