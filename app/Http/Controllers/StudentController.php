<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\TermiiService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request, TermiiService $termii)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'nullable|email|unique:students,email',
            'phone' => 'nullable|string|unique:students,phone',
            'password' => 'required|string|min:8',
            'gender' => 'nullable|in:male,female,others',
            'profile_picture' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'location' => 'nullable|string',
            'home_address' => 'nullable|string',
            'department' => 'nullable|string',
            'guardians_ids' => 'nullable|array',
        ]);
        if (empty($request->input('email')) && empty($request->input('phone'))) {
            return response()->json(['errors' => "Please enter your email or phone number"], 400);
        }
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $student = new Student;
            $student->firstname = $request->input('firstname');
            $student->lastname = $request->input('lastname');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->password = Hash::make($request->input('password'));
            $student->gender = $request->input('gender');
            $student->profile_picture = $request->input('profile_picture');
            $student->date_of_birth = $request->input('date_of_birth');
            $student->location = $request->input('location');
            $student->home_address = $request->input('home_address');
            $student->department = $request->input('department');
            $student->guardians_ids = $request->input('guardians_ids');

            // Initialize optional response
            $smsResponse = null;

            // Handle email verification
            if ($student->email) {
                $student->email_verified_at = null;

                // Send verification email
                Mail::to($student->email)->send(new \App\Mail\StudentEmailVerification($student));
            }

            // Handle phone verification
            if ($student->phone) {
                $code = rand(100000, 999999);
                $student->phone_verification_code = $code;
                $student->is_phone_verified = false;

                // Send SMS and capture response
                $smsResponse = $termii->sendSms($student->phone, "Your verification code is $code");

                \Log::info('Termii SMS response', [
                    'phone' => $student->phone,
                    'response' => $smsResponse
                ]);
            }

            $student->save();

            // Prepare response
            $responsePayload = [
                'student' => $student,
                'message' => $student->email
                    ? 'Verification email sent'
                    : 'Verification code sent to phone',
            ];

            if ($smsResponse) {
                $responsePayload['sms_response'] = $smsResponse;
            }

            return response()->json($responsePayload, 201);

        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }


    // Email Verification
    public function verifyEmail($id)
    {
        $student = Student::findOrFail($id);
        $student->email_verified_at = now();
        $student->save();

        return redirect('/student/dashboard');
    }



    public function sendPhoneVerification(Request $request, TermiiService $termii)
    {
        $request->validate(['phone' => 'required|string']);

        $code = rand(100000, 999999);

        $student = Student::where('phone', $request->phone)->first();

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        $student->phone_verification_code = $code;
        $student->save();

        $termii->sendSms($request->phone, "Your verification code is: $code");

        return response()->json(['message' => 'Verification code sent'], 200);
    }


    // Phone Number Verification
    public function verifyPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string'
        ]);

        $student = Student::where('phone', $request->phone)->where('phone_verification_code', $request->code)->first();

        if (!$student) {
            return response()->json(['error' => 'Invalid code'], 400);
        }

        $student->is_phone_verified = true;
        $student->phone_verification_code = null;
        $student->save();

        return response()->json(['message' => 'Phone verified successfully'], 200);
    }

    /**
     * Display a listing of the students.
     */
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        return response()->json($student);
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        // Validate incoming data
        $data = $request->validate([
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|unique:students,phone,' . $student->id,
            'password' => 'nullable|string|min:6',
            'gender' => 'nullable|in:male,female,others',
            'profile_picture' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'location' => 'nullable|string',
            'home_address' => 'nullable|string',
            'department' => 'nullable|string',
            'guardians_ids' => 'nullable|array',
        ]);

        // Update student
        $student->update($data);

        return response()->json($student);
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }

    /**
     * Optionally, handle login or registration for the student.
     * Example: Using email and password authentication.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $student = Student::where('email', $data['email'])->first();

        if (!$student || !Hash::check($data['password'], $student->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Generate token or handle authentication as needed
        return response()->json(['message' => 'Login successful', 'student' => $student]);
    }
}


