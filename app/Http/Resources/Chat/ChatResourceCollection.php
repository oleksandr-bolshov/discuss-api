<?php

declare(strict_types=1);

namespace App\Http\Resources\Chat;

use Apathy\Discuss\DataObjects\Chat\ChatResponse;
use App\Http\Resources\PaginatedCollectionResource;
use Illuminate\Support\Collection;

final class ChatResourceCollection extends PaginatedCollectionResource
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->toBase());
    }
    public function present(ChatResponse $chat): ChatResource
    {
        return new ChatResource($chat);
    }
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(fn (ChatResponse $chat) => $this->present($chat))->toArray();
    }
}
