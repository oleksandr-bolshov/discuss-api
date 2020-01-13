<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use Apathy\Discuss\DataObjects\User\UserResponse;
use App\Http\Resources\PaginatedCollectionResource;
use Illuminate\Support\Collection;

final class UserResourceCollection extends PaginatedCollectionResource
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->toBase());
    }
    public function present(UserResponse $user): UserResource
    {
        return new UserResource($user);
    }
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(fn (UserResponse $user) => $this->present($user))->toArray();
    }
}
