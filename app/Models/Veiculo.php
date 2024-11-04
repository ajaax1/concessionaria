<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Veiculo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'marca_id',
        'modelo',
        'ano',
        'cor',
        'preco',
        'descricao',
        'status',
        'quilometragem',
        'categoria_id',
    ];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('d/m/Y'),
        );
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }
    
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function opcionais()
    {
        return $this->hasMany( OpcionalVeiculo::class, 'veiculo_id');
    }

    public function imagens()
    {
        return $this->hasMany( ImagemVeiculo::class, 'veiculo_id');
    }
    
}
