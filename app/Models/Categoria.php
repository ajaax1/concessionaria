<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $fillable = ['nome'];

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('d/m/Y'),
        );
    }
}
