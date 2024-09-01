<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
