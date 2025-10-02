<?php

namespace App\Http\Controllers;

use App\Mail\StudentEmailVerification;
use App\Models\Student;
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
        // Validation Student Registration
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'nullable|email|unique:students,email',
            'phone' => 'nullable|string|unique:students,phone',
            'password' => 'required|string|min:8',
            'gender' => 'nullable|in:Male,Female,Others',
            'profile_picture' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'location' => 'nullable|string',
            'home_address' => 'nullable|string',
            'department' => 'nullable|string',
            'guardians_ids' => 'nullable|array',
        ]);

        // Making sure student provide their email or phone number when registering
        if (!$request->email && !$request->phone) {
            return response()->json([
                'message' => 'Email or Phone is required.'
            ], 422);
        }

        // Outputing error while registing when any occures
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $verification_code = rand(100000, 999999);
            $student = new Student;
            $student->firstname = $request->input('firstname');
            $student->lastname = $request->input('lastname');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->password = $request->input('password');
            if($request->has('gender')) {
                $student->gender = $request->input('gender');
            }
            $student->profile_picture = $request->input('profile_picture');
            $student->date_of_birth = $request->input('date_of_birth');
            $student->location = $request->input('location');
            $student->home_address = $request->input('home_address');
            $student->department = $request->input('department');
            $student->guardians_ids = $request->input('guardians_ids');
            $student->verification_code = $verification_code;
            $student->save();

            // Send verification code
            if ($request->email) {
                Mail::to($student->email)->send(new StudentEmailVerification($student));
            } else if ($request->phone) {
                $smsResponse = $termii->sendSms($student->phone, "Your verification code is $verification_code");

                \Log::info('Termii SMS response', [
                    'phone' => $student->phone,
                    'response' => $smsResponse
                ]);
            }

            return response()->json([
                'message' => 'Verification code sent.',
                'student' => $student,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    // Email Verification
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required', // email or phone
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $user = Student::where('email', $request->identifier)
                ->orWhere('phone', $request->identifier)
                ->first();
            if (!$user) {
                return response()->json([
                    'message' => $request->identifier . ' do not exist',
                ], 400);
            } else if ($user->verification_code !== $request->code) {
                return response()->json([
                    'message' => $request->code . ' is not valid',
                ], 400);
            }

            if ($user->email && $user->email === $request->identifier) {
                Student::where('email', $user->email)->update([
                    'email_verified_at' => now(),
                    'verification_code' => null,
                    'verified' => 1,
                ]);
            }
            if ($user->phone && $user->phone === $request->identifier) {
                Student::where('phone', $user->phone)->update([
                    'email_verified_at' => now(),
                    'verification_code' => null,
                ]);
            }
            $user->save();

            return response()->json([
                'message' => 'Verified successfully.',
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'errors' => $error,
            ], 500);
        }

    }

    // Phone Number Verification
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

        try {
            // Update student
            $student->update($data);
            return response()->json(
                [
                    'student' => $student,
                    'message' => 'Student updated successfully',
                ],
                200
            );

        } catch (\Exception $error) {
            return response()->json([
                'errors' => $error->getMessage(),
                'message' => 'An error occurred while updating the student.',
            ], 500);
        }

    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        try {

            $student->delete();
            return response()->json(['message' => 'Student deleted successfully'], 200);
        } catch (\Exception $error) {
            return response()->json([
                'errors' => $error->getMessage(),
                'message' => 'An error occurred while deleting the student.',
            ], 500);
        }
    }

    /**
     * Optionally, handle login or registration for the student.
     * Example: Using email and password authentication.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'identifier' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $student = Student::where('email', $data['identifier'])->orWhere('phone', $data['identifier'])->first();
    
            // Check if the student has verified their email or phone
            if ($student->email_verified_at == null && $student->phone_verified_at == null && $student->verified == 0) {
                return response()->json(['message' => 'Email or Phone not verified'], 401);
            }
    
            // Check if the student exists and the password matches
            if (!$student || !Hash::check($data['password'], $student->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
    
            // Generate token or handle authentication as needed
            return response()->json(['message' => 'Login successful', 'student' => $student], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred during login', 'error' => $e->getMessage()], 500);
        }

    }

    // resending email verification code
    public function resendCode(Request $request, TermiiService $termii) {
        $email = $request->input('email');
        $phone = $request->input('phone');

        // Make sure at least one is provided
        if (!$email && !$phone) {
            return response()->json([
                'message' => 'Provide at least email or phone number'
            ], 422);
        }

        // Find student by email or phone
        if ($email) {
            $student = Student::where('email', $email)->first();
        } elseif ($phone) {
            $student = Student::where('phone', $phone)->first();
        } else {
            $student = null;
        }

        if (!$student) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        if ($student->verified) {
            return response()->json([
                'message' => 'User already verified'
            ], 400);
        }

        // Generate new verification code
        $verification_code = rand(100000, 999999);

        $student->update([
            'verification_code' => $verification_code,
        ]);

        // Send via email if available
        if ($student->email) {
            Mail::to($student->email)->send(new StudentEmailVerification($student));
        }

        // Send via phone if available
        if ($student->phone) {
            $smsResponse = $termii->sendSms($student->phone, "Your verification code is $verification_code");

            \Log::info('Termii SMS response', [
                'phone' => $student->phone,
                'response' => $smsResponse
            ]);
        }

        return response()->json([
            'message' => 'Verification code resent successfully'
        ]);
    }


    //get courses and subjects student enrolled for
    public function getStudentCoursesAndSubjects($studentId)
    {
        $student = Student::select('id', 'firstname', 'lastname')
            ->with([
                'enrollments.course:id,name',
                'enrollments.subjectEnrollments.subject:id,name'
            ])
            ->find($studentId);

        //gives an error message if student id passed is not existing
        if (!$student) {
            return response()->json([
                'message' => 'student does not exist'
            ], 404);
        }

        // Transform structure
        $courses = $student->enrollments->map(function ($enrollment) {
            return [
                'id' => $enrollment->course->id,
                'name' => $enrollment->course->name,
                'subjects' => $enrollment->subjectEnrollments->map(function ($se) {
                    return [
                        'id' => $se->subject->id,
                        'name' => $se->subject->name,
                        'progress' => $se->progress
                    ];
                })->values()
            ];
        })->values();

        return response()->json([
            'id' => $student->id,
            'firstname' => $student->firstname,
            'lastname' => $student->lastname,
            'courses' => $courses
        ], 200);
    }

}


