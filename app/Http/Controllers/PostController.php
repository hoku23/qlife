<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Post_tag;
use Validator;
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
        if (session()->has('user')) {
            $user = session()->get('user');
            $posts = Post::where('user_id', $user->user_id)->where('post_release_flag', 1)->get();
            
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
             
            return view('posts.index', compact('user', 'newPosts'));
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
    
    public function create_tags()
    {
        $user = session()->get('user');
        
        return view('posts.tags_create', compact('user'));
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
                return redirect()->route('posts.create_tags');
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
            return redirect()->route('posts.create_tags');
        } elseif (session()->has('thumnail')) {
            return redirect()->route('posts.create_title')->with('thumnailPath', $thumnailPath)
                                                          ->with('title_message', 'タイトルを入力してください')
                                                          ->with('title', $postTitle_textarea);
        } 
        
    }
    
    public function store_tags(Request $request)
    {
        $raw = file_get_contents('php://input'); // POSTされた生のデータを受け取る
        $data = json_decode($raw); // json形式をphp変数に変換
        
        // やりたい処理
        
        $result = $data;
        
        session()->put('tags', $result);
        $tags = session()->get('tags');
        
        $res = 'Complete';
        echo json_encode($res);
    }
    
    public function show_confirm()
    {
        $user = session()->get('user');
        $title = session()->get('post_title');
        $thumnail = session()->get('thumnail');
        $tags = session()->get('tags');
        $content = session()->get('post_content');
        
        return view('posts.confirm', compact('user', 'title', 'thumnail', 'tags', 'content'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    private $validator = [
            'post_title' =>'required|string',
            'post_content' => 'required|string',
            'thumnail' => 'required|string',
        ]; 
    
    public function release_post()
    {
        $user = session()->get('user');
        
        $input = [
            'post_title' => session()->get('post_title'),
            'post_content' => session()->get('post_content'),
            'thumnail' => session()->get('thumnail'),
            ];
        $validator = Validator::make($input, $this->validator);
        
        if ($validator->fails()) {
            return redirect()->route('posts.confirm')
                             ->withErrors($validator);
        } else {
            $post = new Post();
            $post->post_title = session()->get('post_title');
            $post->post_content = session()->get('post_content');
            $post->thumnail = session()->get('thumnail');
            $post->post_date = date('Y-m-d');
            $post->post_time = date('H:i:s');
            $post->user_id = session()->get('user')->user_id;
            $post->post_release_flag = 1;
            $post->save();
            
            $posts = Post::where('post_title', session()->get('post_title'))->get();
            foreach ($posts as $targetPost)
            $post_id = $targetPost->post_id;
        
            
            session()->forget('post_title');
            session()->forget('post_content');
            session()->forget('thumnail');
            
            $tags = session()->get('tags');
            
            if (isset($tags)) {
                foreach ($tags as $tag) {
                    $post_tag = new Post_tag();
                    $post_tag->post_id = $post_id;
                    $post_tag->tag_name = $tag;
                    $post_tag->save();
                }
            }
            session()->forget('tags');   
            
            return view('posts.complete', compact('user'));    
        }
        
        
    }
    public function draft_post()
    {
        $user = session()->get('user');
        
        $input = [
            'post_title' => session()->get('post_title'),
            'post_content' => session()->get('post_content'),
            'thumnail' => session()->get('thumnail'),
            ];
        $validator = Validator::make($input, $this->validator);
        
        if ($validator->fails()) {
            return redirect()->route('posts.confirm')
                             ->withErrors($validator);
        } else {
            $post = new Post();
            $post->post_title = session()->get('post_title');
            $post->post_content = session()->get('post_content');
            $post->thumnail = session()->get('thumnail');
            $post->post_date = date('Y-m-d');
            $post->post_time = date('H:i:s');
            $post->user_id = session()->get('user')->id;
            $post->post_release_flag = 0;
            $post->save();
            
            $posts = Post::where('thumnail', session()->get('thumnail'))->get();
            foreach ($posts as $targetPost)
            $post_id = $targetPost->post_id;
            
            session()->forget('post_title');
            session()->forget('post_content');
            session()->forget('thumnail');
            
            
            
            $tags = session()->get('tags');
            
            if (isset($tags)) {
                foreach ($tags as $tag) {
                    $post_tag = new Post_tag();
                    $post_tag->post_id = $post_id;
                    $post_tag->tag_name = $tag;
                    $post_tag->save();
                }
            }
            session()->forget('tags');   
            
            return view('posts.draft', compact('user'));    
        }
        
        
    }
     
    public function show()
    {
        //
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
