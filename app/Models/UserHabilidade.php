<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHabilidade extends Model
{
    use HasFactory;

    protected $table = 'users_habilidades';

    protected $fillable = ['user_id', 'habilidade_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function habilidades()
    {
        return $this->belongsTo(Habilidade::class, 'habilidade_id');
    }
}
