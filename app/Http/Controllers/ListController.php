<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Apathy\Discuss\Contracts\ListService;
use Apathy\Discuss\DataObjects\PaginateByIdRequest;
use Apathy\Discuss\DataObjects\UserList\CreateUserListRequest;
use Apathy\Discuss\DataObjects\UserList\MemberRequest;
use Apathy\Discuss\DataObjects\UserList\SubscriberRequest;
use Apathy\Discuss\DataObjects\UserList\UpdateUserListRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\UserList\ListResource;
use App\Http\Resources\UserList\ListResourceCollection;
use App\Http\Response\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListController
{
    private ListService $listService;

    public function __construct(ListService $listService)
    {
        $this->listService = $listService;
    }

    public function getById(int $id): JsonResponse
    {
        return ApiResponse::success(new ListResource($this->listService->find($id)));
    }

    public function paginateByOwnerId(PaginateRequest $request, int $ownerId): JsonResource
    {
        return new ListResourceCollection(
            $this->listService->paginateByOwnerId(
                PaginateByIdRequest::fromArray(
                    ['id' => $ownerId] + $request->toArray()
                )
            )
        );
    }

    public function paginateBySubscriberId(PaginateRequest $request, int $subscriberId): JsonResource
    {
        return new ListResourceCollection(
            $this->listService->paginateBySubscriberId(
                PaginateByIdRequest::fromArray(
                    ['id' => $subscriberId] + $request->toArray()
                )
            )
        );
    }

    public function paginateByMemberId(PaginateRequest $request, int $memberId): JsonResource
    {
        return new ListResourceCollection(
            $this->listService->paginateByMemberId(
                PaginateByIdRequest::fromArray(
                    ['id' => $memberId] + $request->toArray()
                )
            )
        );
    }

    public function create(Request $request): JsonResponse
    {
        $this->listService->create(CreateUserListRequest::fromArray($request->all()));
        return ApiResponse::created();
    }

    public function addSubscriber(Request $request, int $listId): JsonResponse
    {
        $this->listService->addSubscriber(SubscriberRequest::fromArray([
            'list_id' => $listId,
            'subscriber_id' => (int) $request->get('subscriber_id'),
        ]));
        return ApiResponse::success();
    }

    public function addMember(Request $request, int $listId): JsonResponse
    {
        $this->listService->addMember(MemberRequest::fromArray([
            'list_id' => $listId,
            'member_id' => (int) $request->get('member_id'),
        ]));
        return ApiResponse::success();
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $this->listService->update(UpdateUserListRequest::fromArray(
            ['id' => $id] + $request->all()
        ));
        return ApiResponse::success();
    }

    public function delete(int $id): JsonResponse
    {
        $this->listService->delete($id);
        return ApiResponse::empty();
    }

    public function removeSubscriber(Request $request, int $listId): JsonResponse
    {
        $this->listService->removeSubscriber(SubscriberRequest::fromArray([
            'list_id' => $listId,
            'subscriber_id' => (int) $request->get('subscriber_id'),
        ]));
        return ApiResponse::success();
    }

    public function removeMember(Request $request, int $listId): JsonResponse
    {
        $this->listService->removeMember(MemberRequest::fromArray([
            'list_id' => $listId,
            'member_id' => (int) $request->get('member_id'),
        ]));
        return ApiResponse::success();
    }
}
