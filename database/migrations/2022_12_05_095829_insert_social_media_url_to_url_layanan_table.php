<?php

use App\Models\UrlLayanan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $map_url_layanan = [
            [
                'name' => 'Instagram',
                'url' => 'https://www.instagram.com/pupr_sda_baltekrawa/'
            ],
            [
                'name' => 'Facebook',
                'url' => 'https://www.facebook.com/people/Balai-Teknik-Rawa/100066235135162/'
            ],
            [
                'name' => 'Youtube',
                'url' => 'https://www.youtube.com/channel/UCoC8oCFvMLXI0PtEcBp3Plw'
            ]
        ];

        UrlLayanan::insert($map_url_layanan);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('url_layanan', function (Blueprint $table) {
            //
        });
    }
};
