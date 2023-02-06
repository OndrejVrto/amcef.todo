<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MarkNotificationController {
    public function __invoke(Request $request): Response {
        Auth::user()?->unreadNotifications
            ->when($request->input('id'), fn ($query) => $query->where('id', $request->input('id')))
            ->markAsRead();

        return response()->noContent();
    }
}
