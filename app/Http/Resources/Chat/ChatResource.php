<?php

declare(strict_types=1);

namespace App\Http\Resources\Chat;

use App\Http\Resources\User\UserResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

final class ChatResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'last_message' => new MessageResource($this->lastMessage),
            'members' => new UserResourceCollection($this->members),
            'created_at' => $this->createdAt,
        ];
    }
}
