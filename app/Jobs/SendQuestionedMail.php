<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use Mail;
use App\Mail\QuestionNotification;

class SendQuestionedMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    protected $question_user_id;
    protected $question_title;
    protected $question_tags;
    protected $users;  
    
    public function __construct($question_user_id, $question_title, $question_tags, $users)
    {
        $this->question_user_id = $question_user_id;
        $this->question_title = $question_title;
        $this->question_tags = $question_tags;
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        
        $users = $this->users;
        $question_user_id= $this->question_user_id;
        $question_title = $this->question_title;
        $question_tags = $this->question_tags;
        
	   // foreach ($users as $mail_user) {
	   //     $question_user = User::where('user_id', $question_user_id)->first();
	   //     $question_user_name = $question_user->user_name;
	   //     Mail::to($mail_user->email)->send(new QuestionNotification($question_user_name, $question_title, $question_tags));
	   // }
	    
	    $question_user = User::where('user_id', $question_user_id)->first();
        $question_user_name = $question_user->user_name;
        $emails = [];
        
        foreach ($users as $mail_user) {
            array_push($emails, $mail_user->email);
        }
        
        Mail::to('qlife0427@gmail.com', 'Qlife')->bcc($emails)->send(new QuestionNotification($question_user_name, $question_title, $question_tags));
	    
    }
}
