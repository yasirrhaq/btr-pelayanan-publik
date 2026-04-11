<?php

use App\Models\UrlLayanan;
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
        $map_url_layanan = [
            [
                'name' => 'Url Yt Home',
                'url' => 'https://www.youtube.com/embed/2IpaazhVTdk'
            ],
            [
                'name' => 'Url User Manual',
                'url' => ''
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
