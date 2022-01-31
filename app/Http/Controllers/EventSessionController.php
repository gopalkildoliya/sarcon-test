<?php

namespace App\Http\Controllers;

use App\Events\SessionStatusChanged;
use App\Models\EventSession;
use Illuminate\Http\Request;

class EventSessionController extends Controller
{
    public function getSessions(Request $request)
    {
        return EventSession::get();
    }

    public function updateSessionStatus(Request $request, $id)
    {
        abort_unless($request->user()->isAdmin(), 403);

        $request->validate([
            'audience_can_join' => ['required', 'boolean']
        ]);

        $eventSession = EventSession::findOrFail($id);
        $eventSession->audience_can_join = $request->input('audience_can_join');
        $eventSession->save();

        SessionStatusChanged::dispatch($eventSession);
        return $eventSession;
    }
}
