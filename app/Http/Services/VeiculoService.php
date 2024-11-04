<?php

namespace App\Http\Services;
use App\Models\Veiculo;
use App\Http\Requests\VeiculoRequest;
use App\Models\Opcional;
use Illuminate\Http\JsonResponse;
use App\Models\OpcionalVeiculo;
use App\Models\ImagemVeiculo;
use Illuminate\Support\Facades\DB;
class VeiculoService
{
    private $opcionalVeiculo;
    private $veiculo;
    private $imagemVeiculo;

    public function __construct() {
        $this->veiculo = new Veiculo();
        $this->opcionalVeiculo = new OpcionalVeiculo();
        $this->imagemVeiculo = new ImagemVeiculo();
    }

    public function index(): JsonResponse
    {
        return response()->json($this->veiculo->with('marca','categoria')->get());
    }

    public function store(VeiculoRequest $request): JsonResponse
    {
        $data = $request->validated();
        $imagens = $data['imagens'];
        $opcionaisVeiculo = $data['opcionaisVeiculo'];
        unset($data['opcionaisVeiculo']);
        unset($data['imagens']);

        DB::beginTransaction();

        try {
            $veiculo = $this->veiculo->create($data);
            if ($opcionaisVeiculo != null) {
                $opcionais = json_decode($opcionaisVeiculo, true);

                foreach ($opcionais as $opcional) {
                    $opcional['veiculo_id'] = $veiculo->id;
                    $this->opcionalVeiculo->create($opcional);
                }
            }
            $ordem = 1;
            if ($imagens) {
                foreach ($imagens as $imagem) {
                    $url = $imagem->store('imagens', 'public');                    $this->imagemVeiculo->create(['url' => $url, 'veiculo_id' => $veiculo->id, 'ordem' => $ordem]);
                    $ordem++;
                }
            }

            DB::commit();
            return response()->json($veiculo);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao criar veículo', 'details' => $e->getMessage()], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        $veiculo = $this->veiculo->with('marca','categoria','opcionais.opcional','imagens')->find($id);
        if($veiculo->opcionais != null){
            $opcionais = [];
            foreach($veiculo->opcionais as $opcional) {
                $opcionais[] = $opcional->opcional;
            }
            unset($veiculo->opcionais);
            $veiculo->opcionais = $opcionais;
        }
        if($veiculo->imagens != null){
            $imagens = [];
            foreach($veiculo->imagens as $imagem) {
                $imagens[] = $imagem;
            }
            usort($imagens, function ($a, $b) {
                return $a['ordem'] <=> $b['ordem'];
            });
            unset($veiculo->imagens);
            $veiculo->imagens = $imagens;
        }
        return response()->json($veiculo);
    }

    public function update(VeiculoRequest $request, string $id): JsonResponse
    {
        $data = $request->validated();
        DB::beginTransaction();
        $veiculo = $this->veiculo->find($id);

        if(isset($data['opcionaisVeiculo'])){
            $opcionais = json_decode($data['opcionaisVeiculo'], true);
            unset($data['opcionaisVeiculo']);
            $veiculo->opcionais()->delete();
            foreach($opcionais as $opcional) {
                $opcional['veiculo_id'] = $veiculo->id;
                $this->opcionalVeiculo->create($opcional);
            }
        }

        $urlsEnviadas = [];
        $ordem = 1;

        if (isset($data['imagens'])) {
            $imagens = $data['imagens'];
            unset($data['imagens']);
            foreach ($imagens as $imagem) {
                if (is_string($imagem)) {
                    $imagemExistente = $this->imagemVeiculo->where('url', $imagem)->first();
                    if ($imagemExistente) {
                        $imagemExistente->update(['ordem' => $ordem]);
                        $urlsEnviadas[] = $imagem;
                    }
                } else {
                    $url = $imagem->store('imagens', 'public');
                    $this->imagemVeiculo->create([
                        'url' => $url,
                        'veiculo_id' => $veiculo->id,
                        'ordem' => $ordem
                    ]);
                    $urlsEnviadas[] = $url;
                }
                $ordem++;
            }

            $imagensExistentes = $this->imagemVeiculo->where('veiculo_id', $veiculo->id)->get();
            foreach ($imagensExistentes as $imagemExistente) {
                if (!in_array($imagemExistente->url, $urlsEnviadas)) {
                    $imagemExistente->delete();
                }
            }
        }

        $veiculo->update($data);
        DB::commit();
        return response()->json($veiculo);
    }

    public function destroy(string $id): JsonResponse
    {
        $veiculo = $this->veiculo->find($id);
        $this->imagemVeiculo->where('veiculo_id', $id)->delete();        
        $veiculo->delete();
        return response()->json($veiculo);
    }

    public function pesquisa(string $pesquisa): JsonResponse
    {
        return response()->json($this->veiculo->with('marca','categoria')->where('nome','like','%'.$pesquisa.'%')->get());
    }
}