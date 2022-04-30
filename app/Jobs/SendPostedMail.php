<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use Mail;
use App\Mail\PostNotification;

class SendPostedMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    protected $post_user_id;
    protected $post_title;
    protected $post_tags;
    protected $users; 
    
    public function __construct($post_user_id, $post_title, $post_tags, $users)
    {
        $this->post_user_id = $post_user_id;
        $this->post_title = $post_title;
        $this->post_tags = $post_tags;
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
        $post_user_id = $this->post_user_id;
        $post_title = $this->post_title;
        $post_tags = $this->post_tags;
        
        $post_user = User::where('user_id', $post_user_id)->first();
        $post_user_name = $post_user->user_name;
        $emails = [];
        
        foreach ($users as $mail_user) {
            array_push($emails, $mail_user->email);
        }
        
        Mail::to('qlife0427@gmail.com', 'Qlife')->bcc($emails)->send(new PostNotification($post_user_name, $post_title, $post_tags));
        
        
        
	   // foreach ($users as $mail_user) {
	   //     $post_user = User::where('user_id', $post_user_id)->first();
    //         $post_user_name = $post_user->user_name;
    //         Mail::to($mail_user->email)->send(new PostNotification($post_user_name, $post_title, $post_tags));
	   // }
    }
}
