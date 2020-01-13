<?php

declare(strict_types=1);

namespace App\Http\Resources\UserList;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'owner' => new UserResource($this->owner),
            'subscribers_count' => $this->subscribersCount,
            'members_count' => $this->membersCount,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
