<?php

namespace App\Http\Requests\Transactions;

use Illuminate\Foundation\Http\FormRequest;

class MagicDepositRequest extends FormRequest {
    public function authorize() {
        return !app()->isProduction();
    }

    public function rules() {
        return [
            "payee_id" => "required|uuid|exists:users,id",
            "value" => "required|numeric"
        ];
    }

    public function messages() {
        return [
            "payee_id.exists" => "User with id {$this->payee_id} doesn't exists"
        ];
    }
}
