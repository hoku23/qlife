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

    public function create_title(Request $request)
    {
        $user = session()->get('user');
        
        return view('posts.title_thumnail_create', compact('user'));
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
            
            sesstion()->put('content', $content_htmlTag);
            return redirect()->route('posts.create_title');
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
