<?php

use App\Models\LandingPageTipe;
use App\Services\TranslationService;

/**
 * Translate a string from Indonesian to English when the active locale is 'en'.
 * Returns the original text unchanged when locale is 'id'.
 * Safe to call from controllers, views, and Blade templates.
 *
 * Usage in Blade: {{ t('Selamat datang') }}  or  @t('Selamat datang')
 */
if (!function_exists('t')) {
    function t(string $text): string
    {
        return TranslationService::text($text);
    }
}

if (!function_exists('cutText')) {
    function cutText(String $string, $limit = 10){
        $retval = $string;
        $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $string);
        $string = str_replace("\n", " ", $string);
        $array = explode(" ", $string);
        if (count($array)<=$limit)
        {
            $retval = $string;
        }
        else
        {
            array_splice($array, $limit);
            $retval = implode(" ", $array)." ...";
        }
        return $retval;

    }
}

if (!function_exists('toSqlWithBinding')) {
    function toSqlWithBinding($builder, $get = true)
    {
        try {
            $addSlashes = str_replace('?', "'?'", $builder->toSql());
            $query =  vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
            dd($query, $builder->get()->toArray());
        } catch (\Throwable $th) {
            //throw $th;
        }
        $builder_get = collect([]);
        if ($get) {
            $builder_get = $builder->get()->toArray();
        }
        dd($builder->toSql(), $builder->getBindings(), $builder_get);
    }
}

if (!function_exists('slugCustom')) {
    function slugCustom($name)
    {
        $slug = preg_replace('~[^\pL\d]+~u', '-', $name);
        $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug); // transliterate
        $slug = preg_replace('~[^-\w]+~', '', $slug); // remove unwanted characters
        $slug = trim($slug, '-'); // trim
        $slug = preg_replace('~-+~', '-', $slug); // remove duplicate -
        $slug = strtolower($slug); // lowercase

        return $slug;
    }

}

if (!function_exists('globalTipeLanding')) {
    function globalTipeLanding()
    {
        $tipe_landing = LandingPageTipe::all();
        return $tipe_landing;
    }

}

if (!function_exists('imageExists')) {
    function imageExists($path)
    {
        $fallback = asset('assets/fotoDumy.jpeg');

        if (empty($path)) {
            return $fallback;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');
        $absolute = public_path($normalized);

        if (file_exists($absolute)) {
            return asset($normalized);
        }

        return $fallback;
    }
}
