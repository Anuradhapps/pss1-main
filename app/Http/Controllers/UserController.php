<?php

declare(strict_types=1);



namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Helper\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// In your controller (e.g., UserController.php)
use App\Exports\UsersExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;




class UserController extends Controller
{
    public function allpestdata(Request $request)
    {
        // Validate the request
        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        $now = Carbon::now()->format('Y-m-d_H-i-s'); // e.g., 2025-10-03_10-55-00

        $fileName = "pest_data_{$startDate}_to_{$endDate}_downloaded_at_{$now}.xlsx";


        return Excel::download(new UsersExport($startDate, $endDate), $fileName);
    }


    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $user = User::create([
                'name' => trim($validated['name']),
                'email' => strtolower(trim($validated['email'])),
                'password' => Hash::make($validated['password']),
            ]);

            $token = $user->createToken('api-access', ['user:read'])->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'User created successfully.',
                'token' => $token,
            ], 201);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to create account.',
            ], 500);
        }
    }

    public function createUser(Request $request)
    {
        return $this->register($request);
    }

    /**
     * Login user
     * @pram Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ]);

            $user = User::where('email', strtolower(trim($validated['email'])))->first();

            if (! $user || ! Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials.',
                ], 401);
            }

            $token = $user->createToken('api-access', ['user:read'])->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful.',
                'token' => $token,
            ], 200);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to authenticate.',
            ], 500);
        }
    }
}
