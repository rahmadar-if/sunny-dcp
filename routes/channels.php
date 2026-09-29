<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
require __DIR__ . '/../vendor/solaris/solaris-laravel-core/routes/channels.php';
