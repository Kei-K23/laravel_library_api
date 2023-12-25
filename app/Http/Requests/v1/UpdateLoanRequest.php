<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user !== null and $user->tokenCan(['all', 'loan']);
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
                'userId' => ['required', 'numeric'],
                'bookId' => ['required', 'numeric'],
                'status' => ['required', 'string', Rule::in(['LOANED', 'RETURNED'])]
            ];
        }

        if ($method === "PATCH") {
            return [
                'userId' => ['sometimes', 'required', 'numeric'],
                'bookId' => ['sometimes', 'required', 'numeric'],
                'status' => ['sometimes', 'required', 'string', Rule::in(['LOANED', 'RETURNED'])]
            ];
        }
    }


    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->userId,
            'book_id' => $this->bookId,
        ]);
    }
}
