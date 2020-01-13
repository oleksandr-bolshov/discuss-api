<?php

declare(strict_types=1);

namespace App\Http\Resources\Tweet;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class TweetResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'author' => new UserResource($this->author),
            'replies' => new TweetResourceCollection($this->replies),
            'replies_count' => $this->repliesCount,
            'likes_count' => $this->likesCount,
            'in_reply_to_tweet' => $this->inReplyToTweet,
            'images' => new ImageResourceCollection($this->images),
            'poll' => new PollResource($this->poll),
            'created_at' => $this->createdAt,
        ];
    }
}
