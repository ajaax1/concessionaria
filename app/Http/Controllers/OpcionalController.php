<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Opcional;
use \Illuminate\Http\JsonResponse; 
class OpcionalController extends Controller
{
    protected $opcional;

    public function __construct() {
        $this->opcional = new Opcional();
    }

    public function index():JsonResponse
    {
        $data = $this->opcional->all();
        return response()->json($data);
    }

    public function store(Request $request):JsonResponse
    {
        $request->validate([
            'nome' => 'required|max:100',
        ],
        [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.max' => 'O campo nome deve ter no máximo 100 caracteres',
        ]);
        $data = $this->opcional->create($request->all());
        return response()->json($data);
    }

    public function show($id):JsonResponse
    {
        $data = $this->opcional->find($id);
        if($data === null) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }
        return response()->json($data);
    }

    public function update(Request $request, $id):JsonResponse
    {
        $request->validate([
            'nome' => 'required|max:100',
        ],
        [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.max' => 'O campo nome deve ter no máximo 100 caracteres',
        ]);
        $data = $this->opcional->find($id);
        if($data === null) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }
        $data->update($request->all());
        return response()->json($data);
    }

    public function destroy($id):JsonResponse
    {
        $data = $this->opcional->find($id);
        if($data === null) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }
        $data->delete();
        return response()->json(['message' => 'Registro removido com sucesso']);
    }

    public function pesquisa($pesquisa):JsonResponse
    {
        $data = $this->opcional->where('nome', 'like', '%'.$pesquisa.'%')->get();
        return response()->json($data);
    }
}
