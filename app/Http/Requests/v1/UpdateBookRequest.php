<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
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
                "title" => ['required', 'string', 'min:3'],
                "authorId" => ['required', 'numeric'],
                "ISBN" => ['required', 'string'],
                'genre' => ['required', Rule::in(['Fantasy', 'Science Fiction', 'Mystery', 'Romance', 'Thriller', 'Non-Fiction'])],
                'description' => ['required', 'string', 'min:5'],
                'availabilityStatus' => ['required', Rule::in(['AVAILABLE', 'LOANED'])]
            ];
        }

        if ($method === "PATCH") {
            return [
                "title" => ['sometimes', 'required', 'string', 'min:3'],
                "authorId" => ['sometimes', 'required', 'numeric'],
                "ISBN" => ['sometimes', 'required', 'string'],
                'genre' => ['sometimes', 'required', Rule::in(['Fantasy', 'Science Fiction', 'Mystery', 'Romance', 'Thriller', 'Non-Fiction'])],
                'description' => ['sometimes', 'required', 'string', 'min:5'],
                'availabilityStatus' => ['sometimes', 'required', Rule::in(['AVAILABLE', 'LOANED'])]
            ];
        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'author_id' => $this->authorId,
            'availability_status' => $this->availabilityStatus
        ]);
    }
}
