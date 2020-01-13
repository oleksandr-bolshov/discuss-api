<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Apathy\Discuss\Contracts\ChatService;
use Apathy\Discuss\DataObjects\Chat\CreateChatRequest;
use Apathy\Discuss\DataObjects\PaginateByIdRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Chat\ChatResourceCollection;
use App\Http\Response\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ChatController
{
    private ChatService $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function create(Request $request): JsonResponse
    {
        $this->chatService->create(CreateChatRequest::fromArray($request->all()));
        return ApiResponse::created();
    }

    public function delete(int $id): JsonResponse
    {
        $this->chatService->delete($id);
        return ApiResponse::empty();
    }

    public function paginateChatsByUserId(PaginateRequest $request, int $userId): JsonResource
    {
        return new ChatResourceCollection(
            $this->chatService->paginateChatsByUserId(
                PaginateByIdRequest::fromArray(
                    ['id' => $userId] + $request->toArray()
                )
            )
        );
    }
}
