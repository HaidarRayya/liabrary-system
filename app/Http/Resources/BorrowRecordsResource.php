<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BorrowRecordsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_full_name' => User::find($this->user_id)->name,
            'book_id' => $this->book_id,
            'borrowed_at' => $this->borrowed_at,
            'due_date' => $this->due_date ?? '',
            'returned_at' => $this->returned_at
        ];
    }
}
