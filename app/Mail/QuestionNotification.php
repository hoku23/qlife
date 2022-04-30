<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuestionNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $question_user_name;
    public $question_title;
    public $question_tags;
    
    public function __construct($question_user_name, $question_title, $question_tags)
    {
        $this->question_user_name = $question_user_name;
        $this->question_title = $question_title;
        $this->question_tags = $question_tags;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.questioned')
                    ->with(['question_user_name' => $this->question_user_name],
                           ['question_tags' => $this->question_tags],
                           ['question_title' => $this->question_title]
                          );
    }
}
