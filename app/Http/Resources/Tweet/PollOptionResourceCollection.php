<?php

declare(strict_types=1);

namespace App\Http\Resources\Tweet;

use Apathy\Discuss\DataObjects\Poll\PollOptionResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

final class PollOptionResourceCollection extends JsonResource
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->toBase());
    }
    public function present(PollOptionResponse $pollOption): PollOptionResource
    {
        return new PollOptionResource($pollOption);
    }
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(fn (PollOptionResponse $pollOption) => $this->present($pollOption))->toArray();
    }
}
