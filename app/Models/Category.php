<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Race;

class Category extends Model
{
    use HasFactory;

    public $timestamps = true;

    // Categoryは1つのRaceに属する
    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    // Categoryは複数のResultを持つ
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    protected $fillable = [
        'name',
        'race_id',
        'is_team_race',
        'display_order',  // 追加したカラム
    ];

    protected $casts = [
        'is_team_race' => 'boolean',
    ];
}
