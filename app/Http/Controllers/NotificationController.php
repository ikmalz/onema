<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        Notification::create([
            'message' => $request->message,
        ]);

        return response()->json(['success' => true, 'message' => 'Notification sent successfully!']);
    }

    public function fetchNotifications()
    {
        $notifications = Notification::latest()->get();

        return response()->json($notifications);
    }
}
