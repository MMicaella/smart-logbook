<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        auth()->user()
            ->unreadNotifications
            ->markAsRead();

        return view('notifications.index');
    }
}