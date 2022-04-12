<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Post_tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request = session()->get('user')) {
            $user = session()->get('user');
            return view('posts.index', compact('user'));
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = session()->get('user');
        $user_name = $user->user_name;
        $param_json = json_encode($user_name);
        
        $file_name = old('file_name');
        $content = old('content');
        $content_htmlTag = old('content_htmlTag');
        
        return view('posts.content_create', compact('user', 'param_json', 'file_name', 'content', 'content_htmlTag'));
    }

    public function create_title()
    {
        $user = session()->get('user');
        $user_name = $user->user_name;
        $userName = json_encode($user_name);
        
        return view('posts.title_thumnail_create', compact('user', 'userName'));
    }
    
    public function tag_create()
    {
        return view('posts.tags_create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = session()->get('user');
        
        $file_name = $request->input('file_name');
        $content = $request->input('content');
        $content_htmlTag = $request->input('content_htmlTag');
        
        $values = [
            'file_name' => $file_name,
            'content' => $content,
            'content_htmlTag' =>$content_htmlTag,
        ];
            
        
        if ($request->file('content_img')) {
            $img = $request->file('content_img')->storeAs('content_imgs', $file_name, 'public');
        } 
        
        if ($request->input('action') == 'preview') {
            return redirect()->route('posts.create')->withInput($values);   
        } else {
            session()->put('post_content', $content_htmlTag);
            return redirect()->route('posts.create_title');
        }
    }
    
    public function store_title(Request $request) {
        if ($request->input('postTitle')) {
            $title = $request->input('postTitle');
            session()->put('post_title', $title);
            
            if (session()->has('post_title') && session()->has('thumnail')) {
                $thumnail = session()->get('thumnail');
                return redirect()->route('posts.tag_create');
            } elseif (session()->has('post_title')) {
                return redirect()->route('posts.create_title')->with('title', $title)
                                                              ->with('title_message', 'サムネイルを選択してください');    
            }
            
        } else {
            return redirect()->route('posts.create_title')->with('title_message', 'タイトルを入力し直してください');
        }
    }
    
    public function store_thumnail(Request $request) {
        $postTitle_textarea = $request->input('postTitle_textarea');
        if ($request->file('thumnail')) {
            $file_name = $request->input('file_name');
            $thumnailPath = $request->input('thumnailPath');
            $img = $request->file('thumnail')->storeAs('thumnail_imgs', $file_name, 'public');
        } else { 
            
            return redirect()->route('posts.create_title')->with('title_message', '画像を選択し直してください')
                                                          ->with('title', $postTitle_textarea);
        }
        session()->put('thumnail', $thumnailPath);
        
        if (session()->has('thumnail') && session()->has('post_title')) {
            return redirect()->route('posts.create_title')->with('thumnailPath', $thumnailPath);
        } elseif (session()->has('thumnail')) {
            return redirect()->route('posts.create_title')->with('thumnailPath', $thumnailPath)
                                                          ->with('title_message', 'タイトルを入力してください')
                                                          ->with('title', $postTitle_textarea);
        } 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = session()->get('user');
        
        return view('posts.title_thumnail_create', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
