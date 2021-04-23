<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvitedEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $host;
    protected $location;
    protected $code;
    protected $time;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $host, $location, $code, $time)
    {
        $this->name = $name;
        $this->host = $host;
        $this->location = $location;
        $this->code = $code;
        $this->time = $time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invited-email', [
            'name' => $this->name,
            'host' => $this->host,
            'location' => $this->location,
            'code' => $this->code,
            'time' => $this->time
        ]);
    }
}
