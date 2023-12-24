<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "authorId" => $this->author_id,
            "ISBN" => $this->ISBN,
            "genre" => $this->genre,
            "description" => $this->description,
            "availabilityStatus" => $this->availability_status,
        ];
    }
}
