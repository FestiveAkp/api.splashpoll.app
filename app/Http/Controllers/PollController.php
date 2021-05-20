<?php

namespace App\Http\Controllers;

use App\Events\PollVotesUpdated;
use App\Http\Requests\CreatePollRequest;
use App\Http\Requests\VoteRequest;
use App\Models\Choice;
use App\Models\Poll;
use Illuminate\Http\JsonResponse;

class PollController extends Controller
{
    /*
     * GET /polls
     * Retrieve all polls
     */
    public function index(): JsonResponse
    {
        $polls = Poll::with('choices')->get();
        return response()->json($polls);
    }

    /*
     * POST /polls
     * Store a new poll
     */
    public function store(CreatePollRequest $request): JsonResponse
    {
        $poll = Poll::create($request->validated());

        if ($request->has('answers')) {
            $answers = $request->get('answers');

            $choices = array_map(function ($value) {
                return new Choice(['text' => $value]);
            }, $answers);

            $poll->choices()->saveMany($choices);
        }

        $key = 'splashpoll_poll_owner_' . $poll->id;
        $value = $poll->id;
        $duration = 7 * 24 * 60;    // 1 week

        return response()->json($poll->load('choices'))->cookie($key, $value, $duration);
    }

    /*
     * GET /polls/{id}
     * Retrieve a single poll
     */
    public function show(Poll $poll): JsonResponse
    {
        return response()->json($poll->load('choices'));
    }

    /*
     * PATCH /polls/{id}/vote
     * Cast some votes on a poll
     */
    public function vote(VoteRequest $request, Poll $poll): JsonResponse
    {
        $answers = $request->get('answers');

        if ($poll->openEnded) {
            foreach ($answers as $answer) {
                $poll->choices()->updateOrCreate(['text' => $answer])->increment('votes');
            }
            $poll->increment('totalVotes', count($answers));
        }
        else {
            $voteCount = $poll->choices()->whereIn('id', $answers)->increment('votes');
            $poll->increment('totalVotes', $voteCount);
        }

        PollVotesUpdated::dispatch($poll->load('choices'));

        return response()->json($poll);
    }
}
