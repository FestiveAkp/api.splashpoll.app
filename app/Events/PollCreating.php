<?php

namespace App\Events;

use App\Models\Poll;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PollCreating
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The poll instance.
     *
     * @var Poll
     */
    public $poll;


    /**
     * Create a new event instance.
     *
     * @param Poll $poll
     */
    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
    }
}
