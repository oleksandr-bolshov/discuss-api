<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Apathy\Discuss\Contracts\MessageService;
use Apathy\Discuss\DataObjects\Message\CreateMessageRequest;
use Apathy\Discuss\DataObjects\PaginateByIdRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Chat\MessageResourceCollection;
use App\Http\Response\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class MessageController
{
    private MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function send(Request $request): JsonResponse
    {
        $this->messageService->create(CreateMessageRequest::fromArray($request->all()));
        return ApiResponse::created();
    }

    public function read(int $id): JsonResponse
    {
        $this->messageService->read($id);
        return ApiResponse::success();
    }

    public function delete(int $id): JsonResponse
    {
        $this->messageService->delete($id);
        return ApiResponse::empty();
    }

    public function paginateMessagesByChatId(PaginateRequest $request, int $chatId): JsonResource
    {
        return new MessageResourceCollection(
            $this->messageService->paginateMessagesByChatId(
                PaginateByIdRequest::fromArray(
                    ['id' => $chatId] + $request->toArray()
                )
            )
        );
    }
}
