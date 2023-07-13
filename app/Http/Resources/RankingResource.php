<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class RankingResource extends UserResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user id' => $this->id,
            'nickname' => $this->nickname,
            'win percentage' => $this->win_percentage,
        ];
    }
}
