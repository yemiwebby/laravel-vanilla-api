<?php

namespace App\Jobs;

use App\Mail\BulkMail;
use App\Models\MailList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailToUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to([$this->data['to']])->send(new BulkMail($this->data));
        $this->persistToDatabase($this->data);
    }

    private function persistToDatabase($data)
    {
        MailList::create([
            'email' => $data['to'],
            'subject' => $data['subject'],
            'body' => $data['body'],
            'attachments' => $data['attachments'] ?? null
        ]);
    }
}
