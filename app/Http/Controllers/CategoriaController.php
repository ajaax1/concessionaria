<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categoria;
use \Illuminate\Http\JsonResponse;

class CategoriaController extends Controller
{
    private $categoria;
    public function __construct()
    {
        $this->categoria = new Categoria(); 
    }
    public function index(): JsonResponse
    {
        return response()->json($this->categoria->all());
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
        $this->categoria->create($request);
        return response()->json(['msg' => 'categoria criada com sucesso!'],201);
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
        $categoria = $this->categoria->find($id);
        
        $payload = $request->all();
        $categoria->update($payload);
        return response()->json(['msg' => 'Categoria atualizada com sucesso!'],200);
    }

    public function show(string $id): JsonResponse
    {
        $categoria = $this->categoria->find($id);
        return response()->json($categoria);
    }

    public function destroy(string $id): JsonResponse
    {
        $categoria = $this->categoria->find($id);
        $categoria->delete();
        return response()->json(['msg' => 'categoria deletada com sucesso!'],200);
    }

    public function pesquisa(string $pesquisa): JsonResponse
    {
        $categoria = $this->categoria->where('nome','like',"%$pesquisa%")->get();
        return response()->json($categoria);
    }

}
