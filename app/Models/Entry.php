<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'race_id',
        'name',
        'name_kana',
        'gender',
        'age',
        'team_name',
        'start_time',
        'bib_number',
        'category',
        'award_category',
    ];

    public function race()
    {
        return $this->belongsTo(Race::class);
    }
}