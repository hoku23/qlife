<?php

namespace App\Http\Controllers;

use App\User;
use App\Follow;
use App\Post;
use App\Post_tag;
use App\Good;
use App\Save;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        }
        
        $posts = [];
        
        $follows = Follow::where('user_id', $user->user_id)->get();
        foreach ($follows as $follow) {
            $followPosts = Post::where('user_id', $follow->follow_user_id)->where('post_release_flag', 1)->get();
            foreach ($followPosts as $followPost) {
                $follow_tags = [];
                $follow_postTags = Post_tag::where('post_id', $followPost->post_id)->get();
                foreach ($follow_postTags as $follow_postTag) {
                    array_push($follow_tags, $follow_postTag->tag_name);
                }
                $followPost['tags'] = $follow_tags;
                
                $post_user = User::where('user_id', $followPost->user_id)->first();
                $followPost['user_name'] = $post_user->user_name;
                $followPost['user_icon'] = $post_user->user_icon;
                
                $good_nums = Good::where('post_id', $followPost->post_id)->get();
                $good_array = [];
                foreach ($good_nums as $good_num) {
                    array_push($good_array, $good_num);
                }
                
                $followPost['good'] = count($good_array);
                
                $save_check = Save::where('post_id', $followPost->post_id)->where('user_id', $user->user_id)->first();
                if (isset($save_check)) {
                    $followPost['save'] = 1;
                } else {
                    $followPost['save'] = 0;
                }
                
                array_push($posts, $followPost);
            }
        }
        $myPosts = Post::where('user_id', $user->user_id)->where('post_release_flag', 1)->get();
        foreach ($myPosts as $myPost) {
            $tags = [];
            $postTags = Post_tag::where('post_id', $myPost->post_id)->get();
            foreach ($postTags as $postTag) {
                array_push($tags, $postTag->tag_name);
            }
            $myPost['tags'] = $tags;
            
            $post_user = User::where('user_id', $myPost->user_id)->first();
            $myPost['user_name'] = $post_user->user_name;
            $myPost['user_icon'] = $post_user->user_icon;
            
            $good_nums = Good::where('post_id', $myPost->post_id)->get();
            $good_array = [];
            foreach ($good_nums as $good_num) {
                array_push($good_array, $good_num);
            }
            
            $myPost['good'] = count($good_array);
            
            $save_check = Save::where('post_id', $myPost->post_id)->where('user_id', $user->user_id)->first();
            if (isset($save_check)) {
                $myPost['save'] = 1;
            } else {
                $myPost['save'] = 0;
            }
            
            array_push($posts, $myPost);
        }
        
        $date  = array_column($posts, 'post_date');
        $time  = array_column($posts, 'post_time');
        array_multisort($posts, SORT_DESC, $date, $posts, SORT_DESC, $time);
        
        
        return view('homes.timeline', compact('user', 'posts'));
    }
    
    public function users_post(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        }
        
        $post_id = old('post_id');
        
        $post = Post::where('post_id', $post_id)->first();
        $post_user = User::where('user_id', $post->user_id)->first();
        $post['user_name'] = $post_user->user_name;
        $post['user_icon'] = $post_user->user_icon;
        
        
        $post_good = Good::where('post_id', $post_id)->where('user_id', $user->user_id)->first();
        if (isset($post_good)) {
            $post['good'] = 1;
        } else {
            $post['good'] = 0;
        }
        $post_good_nums = Good::where('post_id', $post_id)->get();
        $good_nums = [];
        foreach ($post_good_nums as $post_good_num) {
            array_push($good_nums, $post_good_num);
        }
        
        $good_num = count($good_nums);
        
        $post_save = Save::where('post_id', $post_id)->where('user_id', $user->user_id)->first();
        if (isset($post_save)) {
            $post['save'] = 1;
        } else {
            $post['save'] = 0;
        }
        
        
        return view('homes.users_post', compact('user', 'post', 'good_num'));
    }
    
    public function post_detail(Request $request)
    {
        $detail_post_id = $request->input('post_id');
        
        $values = [
            'post_id' => $detail_post_id,
            ];
        
        return redirect()->route('timeline.users_post')->withInput($values);
    }
}
