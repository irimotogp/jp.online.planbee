<?php

namespace App\Mail\Agency;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Enums\IntroducerType;
use App\Models\Pdf;

class ToRegister extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = Pdf::where('introducer_type', IntroducerType::AGENCY)->first();
        $email = $this->subject('登録申請が完了しました')
        ->markdown('mails.agency.ToRegister');
        if($pdf && $pdf->file) {
            $email->attach($pdf->file);
        }
        return $email;
    }
}
