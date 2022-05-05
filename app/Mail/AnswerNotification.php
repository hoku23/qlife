<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnswerNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $answer_user_name;
    public $question_title;

    public function __construct($answer_user_name, $question_title)
    {
        $this->answer_user_name = $answer_user_name;
        $this->question_title = $question_title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.answered')
                    ->with(['answer_user_name' => $this->answer_user_name],
                           ['question_title' => $this->question_title]
                          );
    }
}
