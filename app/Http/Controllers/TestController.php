<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PestInfoService;

use App\Models\Notification;
use Illuminate\Support\Str;

class TestController extends Controller
{


    public function getCurrentDateTime(PestInfoService $pestInfoService) {}


    public function index()
    {
        //create json data name with age and email
        //add more data as you like
        //multiple lines
        $data = [
            [
                'name' => 'John Doe',
                'age' => 30,
                'email' => 'john.doe@example.com',
                'address' => '123 Main St, Anytown, USA',
                'phone' => '555-1234'
            ],
            [
                'name' => 'Jane Smith',
                'age' => 25,
                'email' => 'jane.smith@example.com',
                'address' => '456 Elm St, Othertown, USA',
                'phone' => '555-5678'
            ],
            [
                'name' => 'Alice Johnson',
                'age' => 28,
                'email' => 'alice.johnson@example.com',
                'address' => '789 Oak St, Sometown, USA',
                'phone' => '555-9012'
            ]
        ];

        return response()->json($data);
    }
}
