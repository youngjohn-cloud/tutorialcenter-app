<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use function Symfony\Component\Clock\now;

class PaymentController extends Controller
{

    //  store payment informations
    public function store(Request $request){
        // Validate the request from frontend
        $request->validate([
            'student_id'      => 'required|exists:students,id',
            'course_id'       => 'required|exists:courses,id',
            'payment_method'  => 'required|in:bank transfer,card,paystack',
            'payment_status' => 'required|in:pending,completed,failed,refunded',
            'amount'          => 'required|numeric|min:1',
            'duration'        => 'required|in:monthly,quarterly,half_year,annually',
            'reference_number' => 'required'
        ],);

        try {
            Payment::create([
                'student_id'        => $request->student_id,
                'course_id'         => $request->course_id,
                'payment_method'    => $request->payment_method,
                'payment_status'    => $request->payment_status,
                'amount'            => $request->amount,
                'duration'          => $request->duration,
                'reference_number'  => $request->reference_number,
                'payment_date'      => now(),
                'due_date'          => $this->calculateDueDate($request->duration)
            ]);

            return response()->json([
                'message' => 'Payment successful'
            ]);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }

    }

    /**
     * Helper: Calculate when the next payment is due based on duration
     */
    private function calculateDueDate($duration){
        return match ($duration) {
            'monthly'   => Carbon::now()->addMonth(),
            'quarterly' => Carbon::now()->addMonths(3),
            'half_year' => Carbon::now()->addMonths(6),
            'annually'  => Carbon::now()->addYear(),
            default     => Carbon::now(),
        };
    }
}
