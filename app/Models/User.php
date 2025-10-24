<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Campos que deben ser ocultos
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Campos que deben ser casteados
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relación: un usuario puede tener muchas preguntas
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Devuelve las iniciales del usuario a partir del nombre.
     *
     * @return string
     */
    public function initials()
    {
        $names = explode(' ', $this->name);
        $initials = '';

        foreach ($names as $n) {
            $initials .= mb_substr($n, 0, 1);
        }

        return strtoupper($initials);
    }
}
