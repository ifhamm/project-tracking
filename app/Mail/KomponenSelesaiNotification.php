<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KomponenSelesaiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $komponen;

    public function __construct($komponen)
    {
        $this->komponen = $komponen;
    }

    public function build()
    {
        return $this->subject('Notifikasi: Komponen Selesai')
            ->view('emails.komponen_selesai')
            ->with([
                'komponen' => $this->komponen
            ]);
    }
}
