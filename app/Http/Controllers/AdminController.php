<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Habilidade;
use App\Models\UserHabilidade;
use Illuminate\Support\Facades\DB; 
class AdminController extends Controller
{
    

    public function __construct(protected User $user, protected Habilidade $habilidade, protected UserHabilidade $userHabilidade)
    {

    }

    public function index(): JsonResponse
    {
        $users = $this->user->with(relations: 'UserHabilidades.habilidades')->orderBy('name')->get();
        
        foreach($users as $user){
            $habilidades = [];
            foreach($user->UserHabilidades as $userHabilidade){
                $habilidades[] = $userHabilidade->habilidades;
            }
            usort($habilidades, function ($a, $b) {
                return $a['id'] <=> $b['id'];
            });            
            unset($user->UserHabilidades);
            $user->habilidades = $habilidades;
        }
        return response()->json($users );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $habilidades = $data['habilidades'];
        unset($data['habilidades']);
        if($data['password'] !== $data['confirm']){
            return response()->json(['message'=>'As senhas não coincidem','errors'=>true], 422);
        }
        DB::beginTransaction();
        $admin = $this->user->create($data);
        foreach($habilidades as $habilidade){
            $habilidade = $this->userHabilidade->create(['user_id'=>$admin->id,'habilidade_id'=>$habilidade['id']]);
        }
        DB::commit();
        return response()->json($admin);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $admin = $this->user->with('UserHabilidades.habilidades')->where('id',$id)->first();
        if($admin === null){
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }
        $habilidades = [];
        if ($admin) {
            foreach ($admin->UserHabilidades as $userHabilidade) {
                $habilidades[] = $userHabilidade->habilidades;
            }       
        }
        usort($habilidades, function ($a, $b) {
            return $a['id'] <=> $b['id'];
        });   
        unset($admin->UserHabilidades);
        $admin->habilidades = $habilidades;
        return response()->json($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request,$id): JsonResponse
    {
        $data = $request->validated();
        $habilidades = $data['habilidades'];
        unset($data['habilidades']);
        $this->userHabilidade->where('user_id', $id)->delete();
        foreach ($habilidades as $habilidade) {
            $this->userHabilidade->create([
                'user_id' => $id,
                'habilidade_id' => $habilidade['id']
            ]);
        }
        if(isset($data['password']) && isset($data['confirm']) && $data['password'] !== $data['confirm']){
            return response()->json(['message'=>'As senhas não coincidem','errors'=>true], 422);
        }
        $admin = $this->user->find($id);
        if($admin === null){
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }
        if($data['password'] == null){
            unset($data['password']);
        }
        $admin->update($data);
        return response()->json($admin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $admin = $this->user->find($id);
        if($admin === null){
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }
        $admin->delete();
        return response()->json(['success' => 'Usuário deletado com sucesso']);
    }

    public function pesquisa(string $pesquisa): JsonResponse{
        $admins = $this->user->with('UserHabilidades.habilidades')->where('name','like',"%$pesquisa%")->get();
        foreach($admins as $admin){
            $habilidades = [];
            foreach($admin->UserHabilidades as $userHabilidade){
                $habilidades[] = $userHabilidade->habilidades;
            }
            usort($habilidades, function ($a, $b) {
                return $a['id'] <=> $b['id'];
            });   
            unset($admin->UserHabilidades);
            $admin->habilidades = $habilidades;
        }
        return response()->json($admins);
    }
}
