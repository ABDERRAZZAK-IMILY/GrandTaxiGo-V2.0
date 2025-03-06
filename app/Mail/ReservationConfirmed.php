<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;

class ReservationConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $qrCodePath;

    public function __construct(Reservation $reservation, $qrCodePath)
    {
        $this->reservation = $reservation;
        $this->qrCodePath = $qrCodePath;
    }

    public function build()
    {
        return $this->subject('validete book')
                    ->view('emails.reservation-confirmed')
                    ->attach(storage_path('app/public/' . $this->qrCodePath), [
                        'as' => 'qrcode.png',
                        'mime' => 'image/png',
                    ]);
    }
} 