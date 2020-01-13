<?php

declare(strict_types=1);

namespace App\Http\Resources\Tweet;

use Illuminate\Http\Resources\Json\JsonResource;

final class PollResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'end_datetime' => $this->endDatetime,
            'options' => new PollOptionResourceCollection($this->options),
        ];
    }
}
