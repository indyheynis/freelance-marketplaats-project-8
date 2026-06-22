<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Commission $commission): View
    {
        $this->authorizeInvolved($commission);

        $messages = $commission->messages()->with('sender')->oldest()->get();

        return view('messages.index', compact('commission', 'messages'));
    }

    public function store(Request $request, Commission $commission): RedirectResponse
    {
        $this->authorizeInvolved($commission);

        $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        Message::create([
            'commission_id' => $commission->id,
            'sender_id' => $request->user()->id,
            'body' => $request->body,
        ]);

        return redirect()->route('messages.index', $commission)
            ->with('success', __('Message sent.'));
    }

    private function authorizeInvolved(Commission $commission): void
    {
        if (! $commission->isInvolvedUser(auth()->id())) {
            abort(403);
        }
    }
}
