<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Apathy\Discuss\Contracts\FollowingService;
use Apathy\Discuss\Contracts\UserService;
use Apathy\Discuss\DataObjects\Following\FollowingRequest;
use Apathy\Discuss\DataObjects\PaginateByIdRequest;
use Apathy\Discuss\DataObjects\User\CreateUserRequest;
use Apathy\Discuss\DataObjects\User\UpdateUserRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\User\UserResourceCollection;
use App\Http\Resources\User\UserResource;
use App\Http\Response\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserController
{
    private UserService $userService;
    private FollowingService $followingService;

    public function __construct(UserService $userService, FollowingService $followingService)
    {
        $this->userService = $userService;
        $this->followingService = $followingService;
    }

    public function getById(int $id): JsonResponse
    {
        return ApiResponse::success(new UserResource($this->userService->find($id)));
    }

    public function register(Request $request): JsonResponse
    {
        $this->userService->create(CreateUserRequest::fromArray($request->all()));
        return ApiResponse::created();
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $this->userService->update(UpdateUserRequest::fromArray(
            ['id' => $id] + $request->all()
        ));
        return ApiResponse::success();
    }

    public function delete(int $id): JsonResponse
    {
        $this->userService->delete($id);
        return ApiResponse::empty();
    }

    public function paginateFollowersByUserId(PaginateRequest $request, int $id): JsonResource
    {
        return new UserResourceCollection(
            $this->userService->paginateFollowersByUserId(
                PaginateByIdRequest::fromArray(
                    ['id' => $id] + $request->toArray()
                )
            )
        );
    }

    public function paginateFollowingsByUserId(PaginateRequest $request, int $id): JsonResource
    {
        return new UserResourceCollection(
            $this->userService->paginateFollowingsByUserId(
                PaginateByIdRequest::fromArray(
                    ['id' => $id] + $request->toArray()
                )
            )
        );
    }

    public function followUserById(Request $request, int $userId): JsonResponse
    {
        $followingRequest = FollowingRequest::fromArray([
            'user_id' => $userId,
            'follower_id' => (int) $request->get('follower_id'),
        ]);

        if ($this->followingService->isFollows($followingRequest)) {
            $this->followingService->unfollow($followingRequest);
            return ApiResponse::empty();
        }

        $this->followingService->follow($followingRequest);
        return ApiResponse::success();
    }

    public function paginateUsersWhoLikedByTweetId(PaginateRequest $request, int $id): JsonResource
    {
        return new UserResourceCollection(
            $this->userService->paginateUsersWhoLikedByTweetId(
                PaginateByIdRequest::fromArray(
                    ['id' => $id] + $request->toArray()
                )
            )
        );
    }

    public function paginateSubscribersByListId(PaginateRequest $request, int $id): JsonResource
    {
        return new UserResourceCollection(
            $this->userService->paginateSubscribersByListId(
                PaginateByIdRequest::fromArray(
                    ['id' => $id] + $request->toArray()
                )
            )
        );
    }

    public function paginateMembersByListId(PaginateRequest $request, int $id): JsonResource
    {
        return new UserResourceCollection(
            $this->userService->paginateMembersByListId(
                PaginateByIdRequest::fromArray(
                    ['id' => $id] + $request->toArray()
                )
            )
        );
    }
}
