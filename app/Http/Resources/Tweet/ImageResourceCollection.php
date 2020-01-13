<?php

declare(strict_types=1);

namespace App\Http\Resources\Tweet;

use Apathy\Discuss\DataObjects\Image\ImageResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

final class ImageResourceCollection extends JsonResource
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->toBase());
    }
    public function present(ImageResponse $image): array
    {
        return [
            'path' => $image->path
        ];
    }
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(fn (ImageResponse $image) => $this->present($image))->toArray();
    }
}
