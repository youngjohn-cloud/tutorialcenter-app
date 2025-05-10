<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Guardian;

class GuardianEmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $guardian;

    /**
     * Create a new message instance.
     */
    public function __construct(Guardian $guardian)
    {
        $this->guardian = $guardian;
    }

    public function build()
    {
        return $this->view('emails.guardian-verification')->with([
            'code' => $this->guardian->verification_code,
        ]);
    }
}
