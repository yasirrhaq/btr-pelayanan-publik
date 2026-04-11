<?php

namespace App\Models;

class Post
{
    private static $berita_posts = [
        [
            "title" => "Judul Berita Pertama",
            "slug" => "judul-berita-pertama",
            "author" => "Yasir Haq",
            "body" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde eos ipsa, non voluptate sed suscipit vero deleniti neque cum, tempora recusandae? Necessitatibus ipsum ab consectetur, est earum possimus dolore qui. Quo ea repellendus officiis ullam, quisquam ex, officia totam expedita doloremque ipsa, nulla non ab. Porro modi doloremque temporibus, accusantium a asperiores, ex inventore commodi at aliquid placeat numquam exercitationem excepturi aut dicta illo ad sit eveniet? Nam iusto ipsum nisi, magni distinctio exercitationem molestiae sit repudiandae animi accusantium debitis.",
            "image" => "https://upload.wikimedia.org/wikipedia/commons/a/a7/Logo_PU_%28RGB%29.jpg"
        ],
        [
            "title" => "Judul Berita Kedua",
            "slug" => 'judul-berita-kedua',
            "author" => "Intan Rahmawati",
            "body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis ea iste quo dicta ipsum reiciendis neque quasi, laboriosam, facere placeat debitis. Asperiores voluptatibus explicabo harum ad voluptatum, voluptates blanditiis totam saepe corporis, quo consequuntur culpa voluptas officia natus sunt esse assumenda reprehenderit maiores omnis hic magnam animi! Voluptate excepturi non nostrum libero eveniet accusantium aperiam id totam beatae ducimus aspernatur quo, incidunt neque magnam. Quisquam sequi expedita ut. Aliquam sunt impedit voluptate ipsa accusantium praesentium ducimus rem officiis, aperiam et quis laudantium consequuntur asperiores omnis quos minima autem ratione modi consectetur pariatur. Laboriosam deleniti saepe nulla quis iste, minima ab!",
            "image" => "https://upload.wikimedia.org/wikipedia/commons/a/a7/Logo_PU_%28RGB%29.jpg"
        ],
    ];

    public static function all()
    {
        return collect(self::$berita_posts);
    }

    public static function find($slug)
    {
        $posts = static::all();
        return $posts->firstWhere('slug', $slug);
    }
}
