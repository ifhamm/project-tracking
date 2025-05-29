<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\part;

class KomponenSelesaiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $komponen;
    public $completedAt;

    public function __construct($komponen, $completedAt)
    {
        $this->komponen = $komponen;
        $this->completedAt = $completedAt;
    }

    public function build()
    {

        
        return $this->subject('Notifikasi: Komponen Selesai')
            ->view('emails.komponen_selesai')
            ->with([
                'komponen' => $this->komponen,
                'completedAt' => $this->completedAt,
            ]);
    }
}
