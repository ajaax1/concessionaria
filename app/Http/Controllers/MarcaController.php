<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Marca;
use \Illuminate\Http\JsonResponse;

class MarcaController extends Controller
{
    private $marca;
    public function __construct()
    {
        $this->marca = new Marca(); 
    }
    public function index(): JsonResponse
    {
        return response()->json($this->marca->all());
    }

    public function store(Request $request): JsonResponse
    {
    $request->validate([
            'nome' => 'required|max:100',
        ],
        [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.max' => 'O campo nome deve ter no máximo 100 caracteres'
        ]
    );
        $request = $request->all();
        $this->marca->create($request);
        return response()->json(['msg' => 'Marca criada com sucesso!'],201);
    }

    public function show(string $id): JsonResponse
    {
        $marca = $this->marca->find($id);
        return response()->json($marca);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'nome' => 'required|max:100',
        ],
        [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.max' => 'O campo nome deve ter no máximo 100 caracteres'
        ]
        );
        $marca = $this->marca->find($id);
        $payload = $request->all();
        $marca->update($payload);
        return response()->json(['msg' => 'Marca atualizada com sucesso!'],200);
    }

    public function destroy(string $id): JsonResponse
    {
        $marca = $this->marca->find($id);
        $marca->delete();
        return response()->json(['msg' => 'Marca deletada com sucesso!'],200);
    }

    public function pesquisa(string $pesquisa): JsonResponse
    {
        $marca = $this->marca->where('nome', 'like', '%'.$pesquisa.'%')->get();
        return response()->json($marca);
    }

}
