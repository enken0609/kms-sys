<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Result extends Model
{
    use HasFactory;

    // Resultは1つのCategoryに属する
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Resultは間接的にRaceに関連する (Categoryを通じてRaceにアクセスする)
    public function race()
    {
        return $this->category->race;
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }
}
