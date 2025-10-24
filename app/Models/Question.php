<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Question extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $fillable = ['title', 'content', 'user_id'];

    // Relación con el usuario que publicó la pregunta
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isHearted()
    {
        return false;
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    
}
