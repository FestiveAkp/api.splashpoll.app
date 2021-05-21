<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteChoiceRequest;
use App\Models\Choice;
use App\Models\Poll;
use Illuminate\Support\Facades\DB;

class ChoiceController extends Controller
{
    /**
     * Remove the specified choice.
     */
    public function destroy(DeleteChoiceRequest $request, Choice $choice): string
    {
        DB::transaction(function () use ($choice) {
            $poll = Poll::find($choice->poll_id);
            $votes = $choice->votes;

            $poll->decrement('totalVotes', $votes);
            $choice->delete();
        });

        return response()->noContent();
    }
}
