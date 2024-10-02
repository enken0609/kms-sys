<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'display_order'];

    // Blockは複数のResultを持つ
    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
