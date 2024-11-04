<?php

namespace App\Http\Controllers;
use App\Models\Habilidade;
use Illuminate\Http\Request;

class HabilidadeController extends Controller
{

    public function __construct(protected Habilidade $habilidade)
    {
    }
    public function index()
    {
        return response()->json($this->habilidade->all());
    }

}
