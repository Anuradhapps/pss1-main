<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PestInfoService;

use App\Models\Notification;
use Illuminate\Support\Str;

class TestController extends Controller
{


    public function index()
    {


        // Example: Generate a notification
        Notification::create([
            'id' => Str::uuid(), // UUID
            'title' => 'New task assigned to you',
            'assigned_to_user_id' => '31284867-d0e7-4872-a7a3-569c99c96994', // The user who will receive the notification
            'assigned_from_user_id' => auth()->id(), // Who created it
            // 'link' => route('test.t'), // Optional link
            'viewed' => false,
        ]);
    }
}
