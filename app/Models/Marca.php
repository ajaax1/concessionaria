<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Marca extends Model
{
    use HasFactory;
    protected $table = 'marcas';
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
