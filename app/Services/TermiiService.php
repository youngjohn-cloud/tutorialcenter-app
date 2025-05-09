<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TermiiService
{
    /**
     * Send an SMS via Termii
     *
     * @param string $to Recipient phone number (e.g. 2348012345678)
     * @param string $message SMS body
     * @return array Termii API response
     */
    public function sendSms($to, $message)
    {
        $url = env('TERMII_SMS_URL', 'https://api.ng.termii.com/api/sms/send'); // fallback to Termii default URL

        $response = Http::post($url, [
            'to' => $to,
            'from' => env('TERMII_SENDER_ID', 'Termii'),
            'sms' => $message,
            'type' => 'plain',
            'channel' => 'generic',
            'api_key' => env('TERMII_API_KEY'),
        ]);

        return $response->json();
    }

    // public function sendSms($to, $message)
    // {
    //     $response = Http::post(env('TERMII_SMS_URL'), [
    //         'to' => $to,
    //         'from' => env('TERMII_SENDER_ID'),
    //         'sms' => $message,
    //         'type' => 'plain',
    //         'channel' => 'generic',
    //         'api_key' => env('TERMII_API_KEY'),
    //     ]);

    //     return $response->json();
    // }
}
