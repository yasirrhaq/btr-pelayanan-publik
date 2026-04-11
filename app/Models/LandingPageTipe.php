<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class LandingPageTipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'landing_page_tipe';
    protected $guarded = ['id'];

    public static function boot(){
        parent::boot();
        static::creating(function($model){
            $slug = Str::slug($model->title, '-');
            $slug = LandingPageTipe::cekSlug($slug);
            $model->slug = $slug;
            $model->created_by = auth()->id() ?? 0;
        });
    }

    public static function cekSlug($slug){
        $jumlah_slug = LandingPageTipe::where('slug', 'like', "%$slug%")
        ->withTrashed()
        ->count();
        return $slug.'-'.$jumlah_slug;
    }
}
