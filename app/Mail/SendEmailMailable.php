<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;



class SendEmailMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;

    // Constructor to pass subject and message to the mailable
    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }

    // Build the message for the email
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject($this->subject)
                    ->view('emails.email_template') // A Blade view for the email content
                    ->with([
                        'msg' => $this->message,
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'TDS',
        );
    }

    /**
     * Get the message content definition.
     */
    /*public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }*/

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
