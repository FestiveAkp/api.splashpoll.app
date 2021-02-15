<?php

namespace App\Listeners;

use App\Events\PollCreating;
use Hidehalo\Nanoid\Client;

class GenerateNanoid
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PollCreating  $event
     * @return void
     */
    public function handle(PollCreating $event)
    {
        // Generate new id using nanoid
        $client = new Client();
        $alphabet = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $event->poll->id = $client->formattedId($alphabet, $size = 10);
    }
}
