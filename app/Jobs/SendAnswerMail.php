<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\AnswerNotification;

class SendAnswerMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $answer_user_name;
    protected $question_title;
    protected $emails; 
    
    public function __construct($answer_user_name, $question_title, $emails)
    {
        $this->answer_user_name = $answer_user_name;
        $this->question_title = $question_title;
        $this->emails = $emails;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        
        $emails = $this->emails;
        $answer_user_name = $this->answer_user_name;
        $question_title = $this->question_title;
        
        Mail::to('qlife0427@gmail.com', 'Qlife')->bcc($emails)->send(new AnswerNotification($answer_user_name, $question_title));
        
        
        
       // foreach ($users as $mail_user) {
       //     $post_user = User::where('user_id', $post_user_id)->first();
    //         $post_user_name = $post_user->user_name;
    //         Mail::to($mail_user->email)->send(new PostNotification($post_user_name, $post_title, $post_tags));
       // }
    }
    
}
