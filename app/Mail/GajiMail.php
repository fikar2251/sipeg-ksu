<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GajiMail extends Mailable
{
    use Queueable, SerializesModels;

    // public $customer;
    public $nik;
    public $nama;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nik, $nama)
    {
        $this->nik = $nik;
        $this->nama = $nama;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            // from: new Address('murif@tabs.co.id', 'PT. Kris Setiabudi Utama'),
            subject: 'Slip Gaji ' . $this->nama . '(' . $this->nik . ')',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'gaji.email',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [

            Attachment::fromPath(public_path('files/' . $this->nik . '.pdf')),
        ];
    }
}
