<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;


class UpdateUserRequest extends FormRequest
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
    public function rules(): array
    {
        $method = $this->method();
        if ($method === "PUT") {
            return [
                'name' => ['required', 'string', 'min:2'],
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
            ];
        }

        if ($method === "PATCH") {
            return [
                'name' => ['sometimes', 'required', 'string', 'min:2'],
                'email' => ['sometimes', 'required', 'string', 'email'],
                'password' => ['sometimes', 'required', 'string'],
            ];
        }
    }
}
