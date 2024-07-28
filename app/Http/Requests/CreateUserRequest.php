<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            "name" => "required|string",
            "email" => "required|email|unique:users",
            "password" => "required|string|min:8|max:255",
            "cpf" => "required|string|regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/"
        ];
    }

    public function messages() {
        return [
            "cpf.regex" => "Invalid cpf format"
        ];
    }

    public function passedValidation() {
        $formattedCpf = str_replace([".", "-"], "", $this->cpf);
        $this->merge([ "cpf" => $formattedCpf ]);
    }
}
