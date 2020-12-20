<?php

namespace App\Mail;

use App\ConsultRequest;
use App\ConsultContact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewContactSurvey extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * The Consult Request instance
	 *
	 * @var consult_contact
	 */
	public $consult_contact;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(ConsultContact $consult_contact)
	{
		$this->consult_contact = $consult_contact;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		return $this->subject('New Survey Requested')->view('emails.new_survey', compact('consult_contact'));
	}
}
