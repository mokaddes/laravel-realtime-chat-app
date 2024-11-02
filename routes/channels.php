<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/



// routes/channels.php
Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
    // Check if the user is authorized to listen to the channel
    return (int) $user->id === (int) $receiverId;
});


