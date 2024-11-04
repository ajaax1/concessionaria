<?php

namespace App\Http\Controllers;
use \Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\OpcionalVeiculo;
class OpcionalVeiculoController extends Controller
{
    protected $opcionalVeiculo;
    public function __construct() {
        $this->opcionalVeiculo = new OpcionalVeiculo();
    }
    public function index():JsonResponse
    {
        $data = $this->opcionalVeiculo->all();
        return response()->json($data);
    }

    public function show($id):JsonResponse
    {
        $data = $this->opcionalVeiculo->find($id);
        if($data === null) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }
        return response()->json($data);
    }

    public function update(Request $request, $id):JsonResponse
    {
        $data = $this->opcionalVeiculo->find($id);
        if($data === null) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }
        $request->validate([
            'nome' => 'required|max:100',
            'veiculo_id' => 'required|exists:veiculos,id'
        ],
        [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.max' => 'O campo nome deve ter no máximo 100 caracteres',
            'veiculo_id.required' => 'O campo veiculo_id é obrigatório',
            'veiculo_id.exists' => 'O veículo informado não existe'
        ]);
        $data->update($request->all());
        return response()->json($data);
    }

    public function destroy($id):JsonResponse
    {
        $data = $this->opcionalVeiculo->find($id);
        if($data === null) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }
        $data->delete();
        return response()->json(['message' => 'Registro removido com sucesso']);
    }
}
