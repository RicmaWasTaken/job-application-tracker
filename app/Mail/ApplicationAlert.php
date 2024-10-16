<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ApplicationAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $applications;

    public function __construct(User $user, $applications)
    {
        $this->user = $user;
        $this->applications = $applications;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder: Applications Older Than 14 Days',
            to: $this->user->email
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.application-alert',
            with: [
                'user' => $this->user,
                'applications' => $this->applications,
            ]
        );
    }

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
