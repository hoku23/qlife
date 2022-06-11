<?php

namespace App\Http\Controllers;

use App\Follow;
use App\User;
use App\Post;
use App\Post_tag;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        $follows = Follow::where('user_id', $user->user_id)->get();
        
        $followUsers = [];
        foreach ($follows as $follow) {
            $follow_users = User::where('user_id', $follow->follow_user_id)->get();
            foreach ($follow_users as $follow_user) {
                // $follow_user_name = $follow_user->user_name;
                array_push($followUsers, $follow_user);
            }
        }
        $follow_num = count($followUsers);
        
        $followers = Follow::where('follow_user_id', $user->user_id)->get();
            
        $newFollowers =[];
        foreach ($followers as $follower) {
            $follower_users = User::where('user_id', $follower->user_id)->get();
            foreach ($follower_users as $follower_user) {
                $follower_user_name = $follower_user->user_name;
                $follower_user_id = $follower_user->user_id;
                $follower_user_icon = $follower_user->user_icon;
                $follow_checks = Follow::where('user_id', $user->user_id)->where('follow_user_id', $follower_user_id)->get();
                foreach ($follow_checks as $follow_check) {
                    if (empty($follow_check)) {
                        $follower['follow_count'] = 0;
                    } else {
                        $follower['follow_count'] = 1;
                    }
                }
            }
            $follower['user_name'] = $follower_user_name;
            $follower['user_icon'] = $follower_user_icon;
            array_push($newFollowers, $follower);
        }
        
        $follower_num = count($newFollowers);
        
        return view('homes.follow', compact('user', 'followUsers', 'follow_num', 'newFollowers', 'follower_num'));
    }
    
    public function user_search(Request $request)
    {
        $user_word = $request->input('user_word');
        $users = User::where('user_name', 'like', "%$user_word%")->get();
        
        return redirect()->route('follow.index')->with('users', $users);
    }
    
    public function user_page(Request $request)
    {
        
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        $otherUser_id = $request->input('otherUser');
        $otherUsers = User::where('user_id', $otherUser_id)->get();
        
        if (empty($otherUser_id)) {
            return redirect()->route('posts.index');
        }
        
        if ($user->user_id == $otherUser_id) {
            return redirect()->route('posts.index');
        } else {
            foreach($otherUsers as $otherUser);
        
            $posts = Post::where('user_id', $otherUser->user_id)->where('post_release_flag', 1)->get();
                
            $newPosts =[];
            foreach ($posts as $post) {
                $tagsRecords = Post_tag::where('post_id', $post->post_id)->get();
                $tags =[];
                foreach ($tagsRecords as $tagsRecord) {
                    $tag = $tagsRecord->tag_name;
                    array_push($tags, $tag);
                }
                $post['tags'] = $tags;
                array_push($newPosts, $post);
            }
            
            $follow_check = Follow::where('user_id', $user->user_id)->where('follow_user_id', $otherUser->user_id)->first();
            if (empty($follow_check)) {
                $follow_infos = 0;
            } else {
                $follow_infos = 1;
            }
            
            $values = [
                'user' => $user,
                'otherUser' => $otherUser,
                'newPosts' => $newPosts,
                'follow' => $follow_infos
            ];
            
            return redirect()->route('follow.user_page_show')->withInput($values);
        }
        
    }
    
    public function user_page_show(Request $request)
    {
            $user = $request->old('user');
            $otherUser = $request->old('otherUser');
            $newPosts = $request->old('newPosts');
            $follow = $request->old('follow');
            
            if (empty($otherUser)) {
                return redirect()->route('posts.index');
            }

        return view('homes.user', compact('user', 'otherUser', 'newPosts', 'follow'));
    }
    
    public function user_follow(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        $otherUser_id = $request->input('follow_user_id');
        $otherUsers = User::where('user_id', $otherUser_id)->get();
        
        foreach($otherUsers as $otherUser);
        
        $posts = Post::where('user_id', $otherUser->user_id)->where('post_release_flag', 1)->get();
            
        $newPosts =[];
        foreach ($posts as $post) {
            $tagsRecords = Post_tag::where('post_id', $post->post_id)->get();
            $tags =[];
            foreach ($tagsRecords as $tagsRecord) {
                $tag = $tagsRecord->tag_name;
                array_push($tags, $tag);
            }
            $post['tags'] = $tags;
            array_push($newPosts, $post);
        }
        
        $follow_users = User::where('user_id', $otherUser_id)->get();
        foreach ($follow_users as $follow_user);
        
        $follow_checks = Follow::where('user_id', $user->user_id)->where('follow_user_id', $follow_user->user_id)->get();
        foreach ($follow_checks as $follow_check);
        // dd($follow_checks);
        // dd(empty($follow_check));
        if (empty($follow_check)) {
            $follow = new Follow();
            $follow->user_id = $user->user_id;
            $follow->follow_user_id = $follow_user->user_id;
            $follow->save();
        } else {
            Follow::where('user_id', $user->user_id)->where('follow_user_id', $follow_user->user_id)->delete();
        }
        $follow_infos = Follow::where('user_id', $user->user_id)->where('follow_user_id', $follow_user->user_id)->get();
        
        if ($request->page == 'otherUser_page') {
            $values = [
                'user' => $user,
                'otherUser' => $otherUser,
                'newPosts' => $newPosts,
                'follow' => $follow_infos
            ];
            
            return redirect()->route('follow.user_page_show')->withInput($values);
        } elseif ($request->page == 'follow_page') {
            return redirect()->route('follow.index');
        }
        
    }
    
    public function follow_remove(Request $request) {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        $remove_follow_user_id = $request->input('follow_user_id');
        
        Follow::where('user_id', $user->user_id)->where('follow_user_id', $remove_follow_user_id)->delete();
        
        return redirect()->route('follow.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function show(Follow $follow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function edit(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Follow $follow)
    {
        //
    }
}
