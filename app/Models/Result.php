<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'place',
        'bib',
        'name',
        'team_name',
        'age',
        'gender',
        'time',
        'difference',
        'start_time'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
