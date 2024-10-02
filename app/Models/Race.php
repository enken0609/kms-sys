<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Race extends Model
{
    use HasFactory;

    // レースには複数のカテゴリが紐づく
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
