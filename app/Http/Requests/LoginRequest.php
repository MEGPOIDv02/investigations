<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'=>'email|required',
            'password'=>'required',
        ];
    }

    public function messages(){
        return [
            'email.required'=>'El email es requerido, por favor',
            'email.email'=>'Ingrese un email valido, por favor',
            'password.required' => 'Debe ingresar su contraseña'
        ];
    }
}
