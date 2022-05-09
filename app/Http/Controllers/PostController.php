<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\User_notice;
use App\Post_tag_notice;
use App\Post_tag;
use App\Save;
use App\Good;
use App\Comment;
use Validator;
use App\Notifications\SendInvitation;
use Mail;
use App\Mail\PostNotification;
use App\Jobs\SendPostedMail;
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
            $posts = Post::where('user_id', $user->user_id)->where('post_release_flag', 1)->orderBy('post_date', 'desc')->orderBy('post_time', 'desc')->get();
            
            $newPosts =[];
            foreach ($posts as $post) {
                $tagsRecords = Post_tag::where('post_id', $post->post_id)->get();
                $tags =[];
                foreach ($tagsRecords as $tagsRecord) {
                    $tag = $tagsRecord->tag_name;
                    array_push($tags, $tag);
                }
                $post['tags'] = $tags;
                
                $good_nums = Good::where('post_id', $post->post_id)->get();
                $good_array = [];
                foreach ($good_nums as $good_num) {
                    array_push($good_array, $good_num);
                }
                
                $post['good'] = count($good_array);
                
                array_push($newPosts, $post);
            }
             
            return view('posts.index', compact('user', 'newPosts'));
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
    }
    
    public function save_post_show()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $saves = Save::where('user_id', $user->user_id)->get();
        
        $posts = [];
        foreach ($saves as $save) {
            $post = Post::where('post_id', $save->post_id)->first();
            $post_user = User::where('user_id', $post->user_id)->first();
            $post['user_name'] = $post_user->user_name;
            $post['user_icon'] = $post_user->user_icon;
            
            $tags = [];
            $post_tags = Post_tag::where('post_id', $post->post_id)->get();
            foreach ($post_tags as $post_tag) {
                array_push($tags, $post_tag->tag_name);
            }
            $post['tags'] = $tags;
            
            $good_nums = Good::where('post_id', $post->post_id)->get();
            $good_array = [];
            foreach ($good_nums as $good_num) {
                array_push($good_array, $good_num);
            }
            $post['good'] = count($good_array);
            
            $post['save_datetime'] = $save->save_datetime;
            
            array_push($posts, $post);
        }
        
        $save_datetime = array_column($posts, 'save_datetime');
        array_multisort($posts, SORT_DESC, $save_datetime);
        
        
        return view('posts.save_posts', compact('user', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        $user_name = $user->user_name;
        $param_json = json_encode($user_name);
        
        $session_content = session()->get('post_content');
        $session_input_content = session()->get('post_input_content');
        
        if(isset($session_input_content)) {
            $content = $session_input_content;
        } else {
            $content = old('content');
        }
        if(isset($session_content)) {
            $content_htmlTag = $session_content;
        } else {
            $content_htmlTag = old('content_htmlTag');
        }
        
        $file_name = old('file_name');

        return view('posts.content_create', compact('user', 'param_json', 'file_name', 'content', 'content_htmlTag'));
    }

    public function create_title()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        $user_name = $user->user_name;
        $userName = json_encode($user_name);
        
        $session_title = session()->get('post_title');
        if(isset($session_title)) {
            $title = $session_title;
        } else {
            $title = null;
        }
        
        $session_thumnail = session()->get('thumnail');
        if(isset($session_thumnail)) {
            $thumnail = $session_thumnail;
        } else {
            $thumnail = null;
        }
        
        return view('posts.title_thumnail_create', compact('user', 'userName', 'title', 'thumnail'));
    }
    
    public function create_tags()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $tags = session()->get('tags');
        $param_json = json_encode($tags);
        
        return view('posts.tags_create', compact('user', 'param_json'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
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
            session()->put('post_input_content', $content);
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
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
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
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
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
            $post->post_date = date('Y.m.d');
            $post->post_time = date('H:i:s');
            $post->user_id = session()->get('user')->user_id;
            $post->post_release_flag = 1;
            $post->save();
            
            $posts = Post::where('thumnail', session()->get('thumnail'))->get();
            foreach ($posts as $targetPost)
            $post_id = $targetPost->post_id;
        
            
            session()->forget('post_title');
            session()->forget('post_content');
            session()->forget('post_input_content');
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
            

    	    $users = [];
    	    $not_user = [];
    	    $notice_users = User_notice::where('notice_user_id', $post->user_id)->whereNotIn('user_id', $not_user)->get();
    	    foreach ($notice_users as $notice_user) {
                $mail_user = User::where('user_id', $notice_user->user_id)->first();
                array_push($users, $mail_user);
                array_push($not_user, $mail_user->user_id);
    	    }
    	   
    	    foreach ((array)$tags as $tag) {
    	        $notice_tags = Post_tag_notice::where('tag_name', $tag)->whereNotIn('user_id', $not_user)->get();
    	        foreach ($notice_tags as $notice_tag) {
    	            $notice_tags_user = User::where('user_id', $notice_tag->user_id)->first();
    	            array_push($users, $notice_tags_user);
    	            array_push($not_user, $notice_tags_user->user_id);   
    	        }
    	    }
    	    
    	    $post_tags = implode('/', (array)$tags);
    	    $post_user_id = $post->user_id;
    	    $post_title = $post->post_title;
    	    
    	    SendPostedMail::dispatch($post_user_id, $post_title, $post_tags, $users);
    	
            return view('posts.complete', compact('user'));    
        }
        
        
    }
    public function draft_post()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
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
            $post->post_date = date('Y.m.d');
            $post->post_time = date('H:i:s');
            $post->user_id = session()->get('user')->user_id;
            $post->post_release_flag = 0;
            $post->save();
            
            $posts = Post::where('thumnail', session()->get('thumnail'))->get();
            foreach ($posts as $targetPost)
            $post_id = $targetPost->post_id;
            
            session()->forget('post_title');
            session()->forget('post_content');
            session()->forget('post_input_content');
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
    
    public function post_delete(Request $request)
    {
        $post_id = $request->input('post_id');
        Post::where('post_id', $post_id)->delete();
        Post_tag::where('post_id', $post_id)->delete();
        Comment::where('path', 'like', "$post_id/%")->delete();
        Save::where('post_id', $post_id)->delete();
        Good::where('post_id', $post_id)->delete();
        
        return redirect()->route('posts.post_deleted');
    }
    
    public function post_deleted()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        return view('posts.deleted', compact('user'));
    }
    
    public function show_draft_post()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $posts = Post::where('user_id', $user->user_id)->where('post_release_flag', 0)->orderBy('post_date', 'desc')->orderBy('post_time', 'desc')->get();
            
        $newPosts =[];
        foreach ($posts as $post) {
            $tagsRecords = Post_tag::where('post_id', $post->post_id)->get();
            $tags =[];
            foreach ($tagsRecords as $tagsRecord) {
                $tag = $tagsRecord->tag_name;
                array_push($tags, $tag);
            }
            $post['tags'] = $tags;
            
            $good_nums = Good::where('post_id', $post->post_id)->get();
            $good_array = [];
            foreach ($good_nums as $good_num) {
                array_push($good_array, $good_num);
            }
            
            $post['good'] = count($good_array);
            
            array_push($newPosts, $post);
        }
        
        return view('posts.draft_post', compact('user', 'newPosts'));
    }
    
    public function release_flag_chnge(Request $request)
    {
        $post_id = $request->input('post_id');
        Post::where('post_id', $post_id)->update(['post_release_flag' => 1]);
        $post = Post::where('post_id', $post_id)->first();
        
        $post_tags = Post_tag::where('post_id', $post_id)->get();
        $tags = [];
        foreach ($post_tags as $post_tag) {
            array_push($tags, $post_tag->tag_name);
        }
        
        $users = [];
	    $not_user = [];
	    $notice_users = User_notice::where('notice_user_id', $post->user_id)->whereNotIn('user_id', $not_user)->get();
	    foreach ($notice_users as $notice_user) {
            $mail_user = User::where('user_id', $notice_user->user_id)->first();
            array_push($users, $mail_user);
            array_push($not_user, $mail_user->user_id);
	    }
	   
	    foreach ($tags as $tag) {
	        $notice_tags = Post_tag_notice::where('tag_name', $tag)->whereNotIn('user_id', $not_user)->get();
	        foreach ($notice_tags as $notice_tag) {
	            $notice_tags_user = User::where('user_id', $notice_tag->user_id)->first();
	            array_push($users, $notice_tags_user);
	            array_push($not_user, $notice_tags_user->user_id);   
	        }
	    }
	    
	    $post_tags = implode('/', $tags);
	    $post_user_id = $post->user_id;
	    $post_title = $post->post_title;
	    
	    SendPostedMail::dispatch($post_user_id, $post_title, $post_tags, $users);
        
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index');
        }
        
        return view('posts.complete', compact('user'));
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
