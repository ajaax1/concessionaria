<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\OpcionalController;
use App\Http\Controllers\OpcionalVeiculoController;
use App\Http\Controllers\HabilidadeController;
use App\Http\Middleware\PermissionCreate;           
use App\Http\Middleware\PermissionUpdate;
use App\Http\Middleware\PermissionDelete;
use App\Http\Middleware\PermissionAdmin;

Route::post('/admin/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'api',], function ($router) {
    Route::get('/verify-token', [AuthController::class, 'verify']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/refresh-token', [AuthController::class, 'refresh']);

    Route::get('/pesquisar-admin/{pesquisa}', [AdminController::class, 'pesquisa']);
    Route::get('/pesquisar-veiculos/{pesquisa}',[VeiculoController::class,'pesquisa']);
    Route::get('/pesquisar-marcas/{pesquisa}',[MarcaController::class,'pesquisa']);
    Route::get('/pesquisar-categorias/{pesquisa}',[CategoriaController::class,'pesquisa']);
    Route::get('/pesquisar-opcionais/{pesquisa}',[OpcionalController::class,'pesquisa']);

    Route::get('/admins', [AdminController::class, 'index']);
    Route::get('/veiculos', [VeiculoController::class, 'index']);
    Route::get('/veiculos/{id}', [VeiculoController::class, 'show']);
    Route::get('/marcas', [MarcaController::class, 'index']);
    Route::get('/marcas/{id}', [MarcaController::class, 'show']);
    Route::get('/categorias', [CategoriaController::class, 'index']);
    Route::get('/categorias/{id}', [CategoriaController::class, 'show']);
    Route::get('/opcionais', [OpcionalController::class, 'index']);
    Route::get('/opcionais/{id}', [OpcionalController::class, 'show']);
    Route::get('/opcionais-veiculos', [OpcionalVeiculoController::class, 'index']);
    Route::get('/opcionais-veiculos/{id}', [OpcionalVeiculoController::class, 'show']);
    Route::get('/habilidades', [HabilidadeController::class, 'index']);
    Route::get('/habilidades/{id}', [HabilidadeController::class, 'show']);

    Route::middleware([PermissionCreate::class])->group(function () {
        Route::post('veiculos', [VeiculoController::class, 'store']);
        Route::post('marcas', [MarcaController::class, 'store']);
        Route::post('categorias', [CategoriaController::class, 'store']);
        Route::post('opcionais', [OpcionalController::class, 'store']);
        Route::post('opcionais-veiculos', [OpcionalVeiculoController::class, 'store']);
    });

    Route::middleware([PermissionUpdate::class])->group(function () {
        Route::put('veiculos/{id}', [VeiculoController::class, 'update']);
        Route::put('marcas/{id}', [MarcaController::class, 'update']);
        Route::put('categorias/{id}', [CategoriaController::class, 'update']);
        Route::put('opcionais/{id}', [OpcionalController::class, 'update']);
        Route::put('opcionais-veiculos/{id}', [OpcionalVeiculoController::class, 'update']);
    });

    Route::middleware([PermissionDelete::class])->group(function () {
        Route::delete('veiculos/{id}', [VeiculoController::class, 'destroy']);
        Route::delete('marcas/{id}', [MarcaController::class, 'destroy']);
        Route::delete('categorias/{id}', [CategoriaController::class, 'destroy']);
        Route::delete('opcionais/{id}', [OpcionalController::class, 'destroy']);
        Route::delete('opcionais-veiculos/{id}', [OpcionalVeiculoController::class, 'destroy']);
    });

    Route::middleware([PermissionAdmin::class])->group(function () {
        Route::post('/admins', [AdminController::class, 'store']);
        Route::put('/admins/{id}', [AdminController::class, 'update']);
        Route::delete('/admins/{id}', [AdminController::class, 'destroy']);
        Route::get('/admins/{id}', [AdminController::class, 'show']);
    });

});
