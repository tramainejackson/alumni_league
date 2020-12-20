<?php

namespace App\Mail;

use App\ConsultRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Update extends Mailable
{
    use Queueable, SerializesModels;

    /**
	* The consult instance
	*
	* @var consult
	*/
	public $consult;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ConsultRequest $consult)
    {
        $this->consult = $consult;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		
        return $this->subject('Pristine Accounting Consult Request')->view('emails.new_message', compact('consult'));
    }
}
