<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
    ];

    // Relación con el usuario que hizo el comentario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación polimórfica inversa
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
