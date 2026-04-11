<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class LandingPage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'landing_page';
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = auth()->id() ?? 0;
        });
        static::updating(function ($model) {
            $model->updated_by = auth()->id() ?? 0;
        });
    }

    public function landingPageTipe(){
        return $this->hasOne(LandingPageTipe::class, 'id', 'landing_page_tipe_id');
    }

    public function getAttrTipeAttribute(){
        return $this->landingPageTipe->title;
    }
}
