<?php

declare(strict_types=1);

namespace App\Http\Resources\Chat;

use Apathy\Discuss\DataObjects\Message\MessageResponse;
use App\Http\Resources\PaginatedCollectionResource;
use Illuminate\Support\Collection;

final class MessageResourceCollection extends PaginatedCollectionResource
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->toBase());
    }
    public function present(MessageResponse $message): MessageResource
    {
        return new MessageResource($message);
    }
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(fn (MessageResponse $message) => $this->present($message))->toArray();
    }
}
