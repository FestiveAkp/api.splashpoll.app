<?php

namespace App\Http\Controllers;

use App\Events\PollVotesUpdated;
use App\Http\Requests\CreatePollRequest;
use App\Http\Requests\VoteRequest;
use App\Models\Choice;
use App\Models\Poll;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PollController extends Controller
{
    /*
     * GET /polls
     * Retrieve all polls
     */
    public function index(): Collection
    {
        return Poll::with('choices')->get();
    }

    /*
     * POST /polls
     * Store a new poll
     */
    public function store(CreatePollRequest $request): Poll
    {
        $poll = Poll::create($request->validated());

        if ($request->has('answers')) {
            $answers = $request->get('answers');

            $choices = array_map(function ($value) {
                return new Choice(['text' => $value]);
            }, $answers);

            $poll->choices()->saveMany($choices);
        }

        return $poll->load('choices');
    }

    /*
     * GET /polls/{id}
     * Retrieve a single poll
     */
    public function show(Poll $poll): Model
    {
        return $poll->load('choices');
    }

    /*
     * PUT|PATCH /polls/{id}
     * Update a poll's information
     */
    public function update(Request $request, Poll $poll): Response
    {
        throw new AuthorizationException('Not implemented');
    }

    /*
     * DELETE /polls/{id}
     * Delete a poll
     */
    public function destroy(Poll $poll): Response
    {
        throw new AuthorizationException('Not implemented');
    }

    /*
     * PATCH /polls/{id}/vote
     * Cast some votes on a poll
     */
    public function vote(VoteRequest $request, Poll $poll): Poll
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

        return $poll->load('choices');
    }
}
