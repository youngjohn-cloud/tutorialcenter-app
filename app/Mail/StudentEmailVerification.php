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

    public function build()
    {
        return $this->subject('Verify Your Email')->view('emails.student-verification')->with([
            'student' => $this->student,
            'url' => $this->url
        ]);
    }
}




// namespace App\Mail;

// use App\Models\Student;
// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;
// use Illuminate\Queue\SerializesModels;

// class StudentEmailVerification extends Mailable
// {
//     use Queueable, SerializesModels;

//     public Student $student;

//     public function __construct(Student $student)
//     {
//         $this->student = $student;
//     }

//     public function envelope(): Envelope
//     {
//         return new Envelope(
//             subject: 'Student Email Verification',
//         );
//     }

//     public function content(): Content
//     {
//         // $verificationUrl = url("/verify-email/student/{$this->student->student_id}");
//         $verificationUrl = config('app.frontend_url') . "/verify-email/student/{$this->student->student_id}";

//         return new Content(
//             view: 'emails.student-verification',
//             with: [
//                 'student' => $this->student,
//                 'url' => $verificationUrl,
//             ]
//         );
//     }

//     public function attachments(): array
//     {
//         return [];
//     }
// }
