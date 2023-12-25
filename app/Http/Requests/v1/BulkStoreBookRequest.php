<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreBookRequest extends FormRequest
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
        return [
            "*.title" => ['required', 'string', 'min:3'],
            "*.authorId" => ['required', 'numeric'],
            "*.ISBN" => ['required', 'string'],
            '*.genre' => ['required', Rule::in(['Fantasy', 'Science Fiction', 'Mystery', 'Romance', 'Thriller', 'Non-Fiction'])],
            '*.description' => ['required', 'string', 'min:5'],
            '*.availabilityStatus' => ['required', Rule::in(['AVAILABLE', 'LOANED'])]
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        foreach ($this->toArray()  as $obj) {

            $obj['title'] = $obj['title'] ?? null;
            $obj['ISBN'] = $obj['ISBN'] ?? null;
            $obj['genre'] = $obj['genre'] ?? null;
            $obj['author_id'] = $obj['authorId'] ?? null;
            $obj['description'] = $obj['description'] ?? null;
            $obj["availability_status"] = $obj['availabilityStatus'] ?? null;
            unset($obj['authorId']);
            unset($obj['availabilityStatus']);
            $data[] = $obj;
        }
        $this->merge($data);
    }
}
