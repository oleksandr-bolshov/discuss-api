<?php

declare(strict_types=1);

namespace App\Http\Resources\Tweet;

use Illuminate\Http\Resources\Json\JsonResource;

final class PollOptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'options' => $this->option,
            'votes_count' => $this->votesCount,
        ];
    }
}
