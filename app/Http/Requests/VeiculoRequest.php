<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VeiculoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'nome' => 'required|string|max:160',
            'marca_id' => 'required|exists:marcas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'modelo' => 'required|string|max:160',
            'ano' => 'required|max:9',
            'cor' => 'required|string|max:10',
            'preco' => [
                'required',
                'numeric',
                'regex:/^\d{1,10}(\.\d{1,2})?$/'
            ],            
            'descricao' => 'nullable|string',
            'status' => 'required|in:USADO,NOVO,SEMINOVO',
            'quilometragem' => 'required|regex:/^\d{1,10}(\.\d{1,3})?$/',
            'cambio' => 'required|in:Manual,Automatico,Automatizado',
            'opcionaisVeiculo' => 'nullable',
            'imagens.*' => 'required',
        ];
    }

    public function messages(){
        return [ 
            'nome.required' => 'O campo nome é obrigatório',
            'marca_id.required' => 'O campo marca é obrigatório',
            'categoria_id.required' => 'O campo categoria é obrigatório',
            'modelo.required' => 'O campo modelo é obrigatório',
            'ano.required' => 'O campo ano é obrigatório',
            'cor.required' => 'O campo cor é obrigatório',
            'preco.required' => 'O campo preço é obrigatório',
            'descricao.required' => 'O campo descrição é obrigatório',
            'status.required' => 'O campo status é obrigatório',
            'quilometragem.required' => 'O campo quilometragem é obrigatório',
            'marca_id.exists' => 'A marca informada não existe',
            'categoria_id.exists' => 'A categoria informada não existe',
            'preco.regex' => 'O campo preço deve ser um número com até 10 digitos e 2 casas decimais',
            'quilometragem.regex' => 'O campo quilometragem deve ser um número com até 10 digitos e 3 casas decimais',
            'OpcionaisVeiculo.required' => 'O campo opcional veiculo é obrigatório',
            'OpcionaisVeiculo.array' => 'O campo opcional veiculo deve ser um array',
            'OpcionaisVeiculo.*.opcionais_id.required' => 'O campo opcional_id é obrigatório',
            'OpcionaisVeiculo.*.opcionais_id.exists' => 'O opcional informado não existe',
            'cambio.required' => 'O campo cambio é obrigatório',
            'cambio.in' => 'O campo cambio deve ser Manual, Automatico ou Automatizado',
            'imagens.required' => 'O campo imagens é obrigatório',
            'imagens.file' => 'O campo imagens deve ser um arquivo',
            'imagens.mimes' => 'O campo imagens deve ser um arquivo do tipo jpeg, png, jpg, gif ou svg',
            'imagens.max' => 'O campo imagens deve ter no máximo 2MB',
        ];
    }

}
