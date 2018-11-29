<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use App\notification;

class SendMessageController extends Controller
{
    public function index()
    {
        return view('send_message');
    }

    public function sendMessage(Request $request)
    {

        $notification = new notification;
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $data['title'] = $request->input('title');
        $data['content'] = $request->input('content');
        /*$notification->title = $data['title'];
        $notification->content = $data['content'];
        $notification->save();*/


        $options = array(
            'cluster'=>'ap1',
            'encrypted' => true,
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $pusher->trigger('Notify', 'send-message', $data);

        return redirect()->route('send');
    }

    public function markAllAsRead()
    {
        $this->markAllAsRead();
        return redirect()->route('send');
    }
}