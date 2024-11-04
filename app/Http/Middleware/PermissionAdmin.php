<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
class PermissionAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = auth()->user()->id;
        $user = User::with('UserHabilidades.habilidades')->find($userId);
        $permissao = false;
        foreach($user->UserHabilidades as $userHabilidade){
            if($userHabilidade->habilidades->nome == 'ADMIN'){
                $permissao = true;
            }
        }
        if(!$permissao){
            return response()->json(['message'=>'Você não tem permissão de admin'], 401);
        }
        return $next($request);
    }
}
