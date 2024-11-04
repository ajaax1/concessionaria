<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;
class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST' ? $this->createRules() : $this->updateRules();
    }

    public function createRules(): array
    {
        return [
            'name' => 'required|max:80',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:119|min:6',
            'confirm' => 'required',
            'habilidades' => 'array',
        ];
    }

    public function updateRules(): array
    {
        $userId = $this->route('id');
        return [
            'name' => 'required|max:80',
            'email' => [
                'required',
                Rule::unique('users')->ignore($userId),
            ],  
            'password' => 'nullable|max:119|min:6',
            'confirm' => 'required_with:password',
            'habilidades' => 'array',
        ];
    }

    public function messages(){
        return[
            'name.required' => 'O campo nome é obrigatório',
            'email.required' => 'O campo email é obrigatório',
            'email.unique' => 'O email informado já está em uso',
            'password.min' => 'O campo senha deve ter no mínimo :min caracteres',
            'password.max' => 'O campo senha deve ter no máximo :max caracteres',
            'password.required' => 'O campo senha é obrigatório',
            'confirm.required' => 'O campo confirmar senha é obrigatório',
            'confirm.required_with' => 'O campo confirmar senha é obrigatório',
            'email' => 'O campo :attribute deve ser um email válido',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres',
            'habilidades.required' => 'O campo habilidades é obrigatório',
            'habilidades.array' => 'O campo habilidades deve ser um array',
        ];
    }
}
