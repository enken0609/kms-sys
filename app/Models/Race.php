<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\CertificateTemplate;

class Race extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'description',
        'series',
        'certificate_template_id'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // シリーズの選択肢を定数として定義
    const SERIES_OPTIONS = [
        'hotaka' => 'HOTAKA SKYRUN',
        'skyvalley' => 'OZEIWAKURA SKYVALLEY',
        'shirane' => 'SHIRANE ASCENT',
        'mountainmarathon' => 'MOUNTAIN MARATHON',
        'snowrun' => 'SNOWRUN',
    ];

    // レースには複数のカテゴリが紐づく
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    // シリーズ名の日本語表示を取得するアクセサ
    public function getSeriesNameAttribute()
    {
        return self::SERIES_OPTIONS[$this->series] ?? $this->series;
    }

    /**
     * このレースで使用する記録証テンプレート
     */
    public function certificateTemplate()
    {
        return $this->belongsTo(CertificateTemplate::class);
    }
}
