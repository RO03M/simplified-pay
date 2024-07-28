<?php

namespace App\Http\Requests\Transactions;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            "value" => "required|numeric|min:0",
            "payer_id" => "required|uuid|exists:users,id",
            "payee_id" => "required|uuid|exists:users,id"
        ];
    }

    public function messages() {
        return [
            "payer_id.exists" => "User who is paying doesn't exist",
            "payee_id.exists" => "User who is being paid doesn't exist"
        ];
    }
}
