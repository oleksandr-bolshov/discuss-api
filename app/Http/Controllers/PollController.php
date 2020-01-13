<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Apathy\Discuss\Contracts\PollService;
use Apathy\Discuss\DataObjects\Poll\HasVotedRequest;
use Apathy\Discuss\DataObjects\Poll\RetractRequest;
use Apathy\Discuss\DataObjects\Poll\VoteRequest;
use App\Http\Response\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PollController
{
    private PollService $pollService;

    public function __construct(PollService $pollService)
    {
        $this->pollService = $pollService;
    }

    public function voteOrRetract(Request $request, int $userId): JsonResponse
    {
        $hasVotedRequest = HasVotedRequest::fromArray([
            'user_id' => $userId,
            'poll_id' => (int) $request->get('poll_id'),
        ]);

        if ($this->pollService->hasVoted($hasVotedRequest)) {
            $this->pollService->retract(RetractRequest::fromArray([
                'user_id' => $userId,
                'poll_option_id' => (int) $request->get('poll_option_id'),
            ]));

            return ApiResponse::empty();
        }

        $this->pollService->vote(VoteRequest::fromArray([
            'user_id' => $userId,
            'poll_id' => (int) $request->get('poll_id'),
            'poll_option_id' => (int) $request->get('poll_option_id'),
        ]));

        return ApiResponse::success();
    }

    public function close(int $id): JsonResponse
    {
        $this->pollService->close($id);
        return ApiResponse::empty();
    }
}
