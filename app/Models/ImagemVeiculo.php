<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagemVeiculo extends Model
{
    use HasFactory;

    protected $table = 'imagens_veiculos';
    protected $fillable = ['url', 'veiculo_id','ordem'];

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}
