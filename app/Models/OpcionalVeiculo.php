<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcionalVeiculo extends Model
{
    use HasFactory;
    protected $fillable = [
        'opcional_id',
        'veiculo_id'
    ];
    protected $table = 'opcionais_veiculos';
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }

    public function opcional()
    {
        return $this->belongsTo(Opcional::class);
    }
}
