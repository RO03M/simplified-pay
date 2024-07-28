<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class GetWalletFromUserRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            "userId" => "required|uuid|exists:users,id"
        ];
    }

    public function prepareForValidation() {
        $this->merge([
            "userId" => $this->userId
        ]);
    }
}
