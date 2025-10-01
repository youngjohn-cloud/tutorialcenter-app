<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class StaffController extends Controller
{
    /**
     * Store a newly created staff in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:staffs,email',
            'phone' => 'nullable|string|unique:staffs,phone',
            'gender' => 'nullable|in:Male,Female,Others',
            'staff_role' => 'nullable|in:admin,tutor,adviser,staff',
            'profile_picture' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'home_address' => 'nullable|string',
            'indected_by' => 'nullable|integer|exists:staff,staff_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if (!$request->email && !$request->phone) {
            return response()->json([
                'message' => 'Email or Phone is required.'
            ], 422);
        }

        // Create staff
        try {
            /*
             *Generate unique staff ID
             *Format: TC{year}{month}{random_number}
             *Example: TC25071234 for a staff created in July 2025 with a random number
             */
            $year = date('ym');
            $rand = rand(1000, 9999);
            $staff_id = 'TC' . $year . $rand;

            $staff = Auth::guard('staffs')->user();

            $staff = new Staff;
            $staff->staff_id = $staff_id;
            $staff->firstname = $request->input('firstname');
            $staff->lastname = $request->input('lastname');
            $staff->email = $request->input('email');
            $staff->phone = $request->input('phone');
            if ($request->has('gender')) {
                $staff->gender = $request->input('gender');
            }
            $staff->password = $staff_id;
            $staff->staff_role = $request->input('staff_role') ?? 'staff';
            $staff->profile_picture = $request->input('profile_picture');
            $staff->date_of_birth = $request->input('date_of_birth');
            $staff->home_address = $request->input('home_address');
            // $staff->indected_by = $request->input('indected_by');
            $staff->indected_by = $staff->id;

            $staff->verified = false;
            $staff->status = 'inactive';
            $staff->save();

            // Send verification code
            if ($request->email) {
                Mail::send('emails.staff-induction', [
                    'firstname' => $staff->firstname,
                    'lastname' => $staff->lastname,
                    'role' => $staff->staff_role,
                    'staff_id' => $staff->staff_id,
                    'email' => $staff->email,
                    'login_link' => env('FRONTEND_URL') . '/api/staff/login',
                ], function ($message) use ($staff) {
                    $message->to($staff->email)
                        ->subject('Welcome to Tutorial Center!');
                });

            } else if ($request->phone) {
                // $smsResponse = $termii->sendSms($staff->phone, "Your verification code is $verification_code");

                \Log::info('Termii SMS response', [
                    'phone' => $staff->phone,
                    // 'response' => $smsResponse
                ]);
            }

            return response()->json([
                'message' => 'Staff created successfully. Induction mail has been sent.',
                'staff' => $staff,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    //staff login method
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

          $credentials = $request->only('email', 'password');

        if (Auth::guard('staff')->attempt($credentials)) {
            $staff = Auth::guard('staff')->user();

            // Make sure staff is authenticated and saved
            if (!$staff || !$staff->id) {
                return response()->json([
                    'message' => 'Something went wrong, user not authenticated properly.'
                ], 500);
            }

            $token = $staff->createToken('staff-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'staff' => $staff,
                'staff-token' => $token,
            ], 200);
        }

        return response()->json(['message' => 'Invalid email or password'], 401);
    }

    //     $data = $request->validate([
    //         'identifier' => 'required|email',
    //         'password' => 'required|string',
    //     ]);
    //     return "Hello";

    //     try {
    //         $staff = Staff::where('email', $data['identifier'])->orWhere('phone', $data['identifier'])->first();

    //         if (!$staff || !Hash::check($data['password'], $staff->password)) {
    //             return response()->json(['message' => 'Invalid credentials'], 401);
    //         }

    //         // Generate token or handle authentication as needed
    //         return response()->json(['message' => 'Login successful', 'staff' => $staff], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'An error occurred during login', 'error' => $e->getMessage()], 500);
    //     }

    // }


    // Update Staff Info
    public function update(Request $request, Staff $staff)
    {
        // Validate incoming data
        $data = $request->validate([
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:staffs,email,' . $staff->id,
            'phone' => 'nullable|string|unique:staffs,phone,' . $staff->id,
            'password' => 'nullable|string|min:6',
            'gender' => 'nullable|in:male,female,others',
            'profile_picture' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'home_address' => 'nullable|string',
            'staff_role' => 'nullable|in:admin,tutor,adviser,staff',
            'indected_by' => 'nullable|integer|exists:staff,staff_id',
        ]);

        try {
            // Update staff profile
            $staff->update($data);
            return response()->json([
                'staff' => $staff,
                'message' => 'Staff profile updated successfully',
            ], 200);

        } catch (\Exception $error) {
            return response()->json([
                'errors' => $error->getMessage(),
                'message' => 'An error occurred while updating the student.',
            ], 500);
        }
    }

    // Show staffs
    public function show() {
        $staffs = Staff::all();
        return response()->json([
            'staffs' => $staffs
        ], 200);
    }
}
