<?php

declare(strict_types=1);

namespace App\Http\Resources\UserList;

use Apathy\Discuss\DataObjects\UserList\UserListResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

final class ListResourceCollection extends JsonResource
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->toBase());
    }
    public function present(UserListResponse $list): ListResource
    {
        return new ListResource($list);
    }
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(fn (UserListResponse $list) => $this->present($list))->toArray();
    }
}
