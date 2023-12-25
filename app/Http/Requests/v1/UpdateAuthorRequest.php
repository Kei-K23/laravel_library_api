<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user !== null and $user->tokenCan('all');
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
                'biography' => ['required', 'string', 'min:4']
            ];
        }

        if ($method === "PATCH") {
            return [
                'name' => ['sometimes', 'required', 'string', 'min:2'],
                'biography' => ['sometimes', 'required', 'string', 'min:4']
            ];
        }
    }
}
