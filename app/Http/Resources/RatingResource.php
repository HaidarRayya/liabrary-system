<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $customer = User::find($this->user_id);
        return [
            'id' => $this->id,
            'review' => $this->review ?? '',
            'rating' => $this->rating,
            'fullName' => $customer->name,
        ];
    }
}
