<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Rating;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $ratings = Rating::where('book_id', '=', $this->id);
        $rating = $ratings->avg('rating');
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'image' => asset('storage/' .  $this->image),
            'descripation' => $this->descripation,
            'published_at' => $this->published_at,
            'category' => $this->category,
            'numberOfRatings' => count($ratings->get()),
            'rating' => (float)$rating ?? 0.0
        ];
    }
}
