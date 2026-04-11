<?php

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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->text('excerpt');
            $table->text('body');
            $table->timestamp('publish_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};

// Post::create([
//     'title'=>'Judul Berita Kelima',
//     'category_id'=>1,
//     'slug'=>'judul-berita-kelima',
//     'excerpt'=>'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Neque iusto veniam ad dignissimos dolorum minus aperiam itaque, repellat adipisci recusandae.',
//     'body'=>'<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Rerum magnam, ipsum distinctio amet, repudiandae beatae, culpa molestiae odit et eaque expedita necessitatibus tenetur.</p> <p>Aliquam perferendis rerum veritatis dignissimos repudiandae! Sequi totam vero molestiae at amet animi eligendi nam atque nisi quae incidunt tenetur placeat, ipsa illum maxime sit perferendis quod eius maiores. Possimus rerum aspernatur obcaecati sequi blanditiis sed fugit saepe ab ea provident ducimus accusamus ut omnis, voluptatem perferendis dolor optio debitis vero alias nihil vel at totam.</p> Debitis dolore ut quod voluptate soluta libero corrupti ipsa dignissimos incidunt aut optio dolores, obcaecati cupiditate enim ea eligendi rem quia vero impedit, atque reiciendis quam maiores quaerat? Quasi, recusandae odit.'
// ])