<?php

namespace App\Http\Resources\v1;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'userId' => $this->user_id,
            'bookId' => $this->book_id,
            'status' => $this->status,
            'loanDate' => $this->loan_date,
            'dueDate' => $this->due_date,
            'user' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
