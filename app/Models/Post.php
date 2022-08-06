<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ["id", "description", "user_id", "created_at", "updated_at"];

    public function like() {
        return $this->hasMany(Like::class);
    }

    public function comment() {
        return $this->hasMany(Comment::class);
    }
}
