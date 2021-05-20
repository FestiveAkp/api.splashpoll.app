<?php

namespace App\Http\Middleware;

use App\Models\Choice;
use Closure;
use Illuminate\Http\Request;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get request's poll id
        $path = explode('/', $request->path());
        $choice_id = array_pop($path);
        $choice = Choice::find($choice_id);
        $poll_id = $choice->poll_id;

        // Get client cookie
        $cookie = $request->cookie('splashpoll_poll_owner_' . $poll_id);

        // Check if client has access
        if ($cookie != $poll_id) {
            return response('Forbidden', 403);
        }
        else {
            return $next($request);
        }
    }
}
