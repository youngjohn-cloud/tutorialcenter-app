<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Student;

class StudentEmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $url;

    public function __construct(Student $student)
    {
        $this->student = $student;

        // You can generate a temporary signed URL or just pass a dummy one for now
        $this->url = url('/verify-email/' . $student->id); 
    }

    // public function build()
    // {
    //     return $this->subject('Verify Your Email')->view('emails.student-verification')->with([
    //         'student' => $this->student,
    //         'url' => $this->url
    //     ]);
    // }

    public function build()
    {
        return $this->view('emails.student-verification')->with(['code' => $this->student->verification_code]);
    }
}