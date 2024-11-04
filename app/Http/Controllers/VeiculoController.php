<?php

namespace App\Http\Controllers;
use App\Http\Requests\VeiculoRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Services\VeiculoService;
class VeiculoController extends Controller
{
    public function __construct(protected VeiculoService $veiculoService) {}

    public function index(): JsonResponse
    {
        return $this->veiculoService->index();
    }

    public function store(VeiculoRequest $request): JsonResponse
    {
        return $this->veiculoService->store($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->veiculoService->show($id);
    }

    public function update(VeiculoRequest $request, string $id): JsonResponse
    {
        return $this->veiculoService->update($request, $id);
    }

    public function destroy(string $id): JsonResponse
    {
        return $this->veiculoService->destroy($id);
    }

    public function pesquisa(string $pesquisa): JsonResponse
    {
        return $this->veiculoService->pesquisa($pesquisa);
    }
}