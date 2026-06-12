<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index()
    {
        $messages = Message::with('sender', 'receiver')
            ->latest()
            ->paginate(15);

        $unreadCount = Message::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject'     => 'nullable|string|max:255',
            'body'        => 'required|string',
        ]);

        $validated['sender_id'] = auth()->id();

        $message = Message::create($validated);

        AuditLog::record('Created', 'messages', $message->id, "Message sent to '" . $message->receiver->name . "'");

        return redirect()->back();
    }

    public function destroy(Message $message)
    {
        $messageId = $message->id;
        $message->delete();

        AuditLog::record('Deleted', 'messages', $messageId, 'Message deleted');

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted');
    }
}
