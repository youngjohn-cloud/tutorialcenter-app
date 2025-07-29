<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
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
            'email' => 'required|email|unique:staff,email',
            'phone' => 'nullable|string|unique:staff,phone',
            'password' => 'required|string|min:8',
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
            $verification_code = rand(100000, 999999);

            $staff = new Staff;
            $staff->firstname = $request->input('firstname');
            $staff->lastname = $request->input('lastname');
            $staff->email = $request->input('email');
            $staff->phone = $request->input('phone');
            $staff->password = bcrypt($request->input('password'));
            $staff->gender = $request->input('gender');
            $staff->staff_role = $request->input('staff_role') ?? 'staff';
            $staff->profile_picture = $request->input('profile_picture');
            $staff->date_of_birth = $request->input('date_of_birth');
            $staff->home_address = $request->input('home_address');
            $staff->indected_by = $request->input('indected_by');
            $staff->verification_code = $verification_code;
            $staff->verified = false;
            $staff->status = 'inactive';
            $staff->save();

            // Send verification code
            if ($request->email) {
                // Mail::to($staff->email)->send(new \App\Mail\StaffEmailVerification($staff));
            } else if ($request->phone) {
                // $smsResponse = $termii->sendSms($staff->phone, "Your verification code is $verification_code");

                \Log::info('Termii SMS response', [
                    'phone' => $staff->phone,
                    // 'response' => $smsResponse
                ]);
            }

            return response()->json([
                'message' => 'Verification code sent.',
                'staff' => $staff,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
