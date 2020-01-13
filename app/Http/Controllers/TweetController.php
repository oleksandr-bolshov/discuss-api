<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Apathy\Discuss\Contracts\LikeService;
use Apathy\Discuss\Contracts\TweetService;
use Apathy\Discuss\DataObjects\Like\LikeRequest;
use Apathy\Discuss\DataObjects\PaginateByIdRequest;
use Apathy\Discuss\DataObjects\Tweet\CreateTweetRequest;
use Apathy\Discuss\DataObjects\Tweet\PaginateRequest;
use App\Http\Requests\PaginateRequest as PaginateFormRequest;
use App\Http\Resources\Tweet\TweetResource;
use App\Http\Resources\Tweet\TweetResourceCollection;
use App\Http\Response\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TweetController
{
    private TweetService $tweetService;
    private LikeService $likeService;

    public function __construct(TweetService $tweetService, LikeService $likeService)
    {
        $this->tweetService = $tweetService;
        $this->likeService = $likeService;
    }

    public function paginate(PaginateFormRequest $request): JsonResource
    {
        return new TweetResourceCollection(
            $this->tweetService->paginate(
                PaginateRequest::fromArray($request->toArray())
            )
        );
    }

    public function getById(int $id): JsonResponse
    {
        return ApiResponse::success(new TweetResource($this->tweetService->find($id)));
    }

    public function paginateByUserId(PaginateFormRequest $request, int $userId): JsonResource
    {
        return new TweetResourceCollection(
            $this->tweetService->paginateByUserId(
                PaginateByIdRequest::fromArray(
                    ['id' => $userId] + $request->toArray()
                )
            )
        );
    }

    public function create(Request $request): JsonResponse
    {
        $this->tweetService->create(CreateTweetRequest::fromArray($request->all()));
        return ApiResponse::created();
    }

    public function delete(int $id): JsonResponse
    {
        $this->tweetService->delete($id);
        return ApiResponse::empty();
    }

    public function likeOrUnlikeTweet(Request $request, int $id): JsonResponse
    {
        $likeRequest = LikeRequest::fromArray([
            'tweet_id' => $id,
            'user_id' =>  (int) $request->get('user_id'),
        ]);

        if ($this->likeService->isLikes($likeRequest)) {
            $this->likeService->unlike($likeRequest);
            return ApiResponse::empty();
        }

        $this->likeService->like($likeRequest);
        return ApiResponse::success();
    }

    public function paginateByListId(PaginateFormRequest $request, int $listId): JsonResource
    {
        return new TweetResourceCollection(
            $this->tweetService->paginateByListId(
                PaginateByIdRequest::fromArray(
                    ['id' => $listId] + $request->toArray()
                )
            )
        );
    }
}
