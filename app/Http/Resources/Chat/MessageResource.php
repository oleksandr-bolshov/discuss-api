<?php

declare(strict_types=1);

namespace App\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;

final class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sender' => $this->user,
            'text' => $this->text,
            'is_read' => $this->isRead,
            'sent_at' => $this->createdAt,
        ];
    }
}
