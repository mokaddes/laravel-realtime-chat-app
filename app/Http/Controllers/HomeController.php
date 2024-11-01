<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::query()
                ->where('id', '!=', Auth::user()->id)
                ->get();
        return view('home', compact('users'));
    }

    public function users()
    {
        $ids = Chat::query()
                ->select('sender_id', 'receiver_id')
                ->where('sender_id', Auth::user()->id)
                ->orWhere('receiver_id', Auth::user()->id)
                ->get()
                ->pluck('sender_id')
                ->merge(Chat::query()
                    ->select('sender_id', 'receiver_id')
                    ->where('sender_id', Auth::user()->id)
                    ->orWhere('receiver_id', Auth::user()->id)
                    ->get()
                    ->pluck('receiver_id'))
                ->unique();
        $users = User::query()
                ->where('id', '!=', Auth::user()->id)
                ->whereIn('id', $ids)
                ->get();
        return response()->json(['users' => $users]);
    }
    public function chat($id)
    {
        $user = User::query()
                ->findOrFail($id);
        return view('chat', compact('user'));
    }

    public function fetchMessages($id)
    {
        $chat = Chat::where(function ($query) use ($id) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('sender_id', $id)
                  ->where('receiver_id', auth()->id());
        })->with('sender')
        ->get();

        return response()->json(['chat' => $chat]);
    }

    public function chatSent(Request $request)
    {
        try {
            DB::beginTransaction();

            $chatMessage = new Chat();
            $chatMessage->sender_id = Auth::user()->id;
            $chatMessage->receiver_id = $request->receiver_id;
            $chatMessage->message = $request->message;
            $chatMessage->save();


            broadcast(new MessageEvent($request->message, $request->receiver_id, Auth::user()))->toOthers();


            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Message sent successfully!',
                "chat" => $chatMessage,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send message!',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
