<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserHabilidade;
class Habilidade extends Model
{
    use HasFactory;

    protected $table = 'habilidades';
    protected $fillable = ['nome'];

    public function UserHabilidade()
    {
        return $this->hasMany(UserHabilidade::class, 'habilidade_id');
    }

}
