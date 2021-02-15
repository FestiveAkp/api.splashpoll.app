<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePollRequest;
use App\Models\Choice;
use App\Models\Poll;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Poll::with('choices')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePollRequest $request
     * @return Model
     */
    public function store(StorePollRequest $request): Model
    {
        $poll = Poll::create($request->validated());
        $answers = $request->get('answers');

        $choices = array_map(function ($value) {
            return new Choice(['text' => $value]);
        }, $answers ?? []);

        $poll->choices()->saveMany($choices);

        return $poll->load('choices');
    }

    /**
     * Display the specified resource.
     *
     * @param Poll $poll
     * @return Model
     */
    public function show(Poll $poll): Model
    {
        return $poll->load('choices');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Poll $poll
     * @return Response
     */
    public function update(Request $request, Poll $poll): Response
    {
        $poll->update($request->all());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Poll $poll
     * @return Response
     */
    public function destroy(Poll $poll): Response
    {
        $poll->delete();
        return response()->noContent();
    }
}
