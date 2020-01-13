<?php

declare(strict_types=1);

namespace App\Http\Resources\Tweet;

use Apathy\Discuss\DataObjects\Tweet\TweetResponse;
use App\Http\Resources\PaginatedCollectionResource;
use Illuminate\Support\Collection;

final class TweetResourceCollection extends PaginatedCollectionResource
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->toBase());
    }
    public function present(TweetResponse $tweet): TweetResource
    {
        return new TweetResource($tweet);
    }
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(fn (TweetResponse $tweet) => $this->present($tweet))->toArray();
    }
}
