<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     
    public $post_user_name;
    public $post_title;
    public $post_tags;
    
    public function __construct($post_user_name, $post_title, $post_tags)
    {
        $this->post_user_name = $post_user_name;
        $this->post_title = $post_title;
        $this->post_tags = $post_tags;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.posted')
                    ->with(['post_user_name' => $this->post_user_name],
                           ['post_tags' => $this->post_tags],
                           ['post_title' => $this->post_title]
                          );
    }
}
