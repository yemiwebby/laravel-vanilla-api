<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BulkMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): BulkMail
    {
        $mail = $this->subject($this->details['to'])
            ->view('mail.bulkMail')->with('details', $this->details);


        if (!empty($this->details['attachments'])) {
            if (is_array($this->details['attachments'])) {
                foreach ($this->details['attachments'] as $detail => $att) {
                    $mail = $mail->attachData(base64_decode($att['base64']), $att['filename'], ['mime' => $att['filetype']]);
                }
            } else {
                $mail = $mail->attach($this->details['attachments']);
            }
        }
        return $mail;
    }
}
