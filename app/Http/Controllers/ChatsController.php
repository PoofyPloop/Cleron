<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Message;

class ChatsController extends Controller 
{
    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messages = Message::query()
            ->where('sender_id',  auth()->user()->id)
            ->orWhere('receiver_id',  auth()->user()->id)
            ->with('sender')
            ->with('receiver')
            ->get();
        
        return Inertia::render('Chat', [
            'messages' => $messages
        ]);
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        $user = auth()->user();

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        return response()->json([
            'status' => 'Message Sent!'
        ]);
    }
}