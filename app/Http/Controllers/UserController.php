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


    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'

                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'error' => $validateUser->error()
                ], 401);
            }
            $user = User::Create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()

            ], 500);
        }
    }

    /**
     * Login user
     * @pram Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email|',
                    'password' => 'required'

                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'error' => $validateUser->error()
                ], 401);
            }
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email and the password dont match'

                ], 401);
            }
            $user = User::where('email', $request->email)->first();
            return response()->json([
                'status' => true,
                'id' => $user->id,
                'message' => 'User Login  Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()

            ], 500);
        }
    }
}
