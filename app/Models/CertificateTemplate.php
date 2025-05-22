<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CertificateTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_path',
        'paper_size',
        'orientation',
        'layout_config'
    ];

    protected $casts = [
        'layout_config' => 'array'
    ];

    /**
     * このテンプレートを使用しているレース一覧を取得
     */
    public function races(): HasMany
    {
        return $this->hasMany(Race::class);
    }
}
