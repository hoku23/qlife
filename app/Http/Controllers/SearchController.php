<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Post_tag;
use App\Good;
use App\Save;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    public function post_search(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        }
        
        $keyword = $request->input('keyword');
        
        $values = [
            'keyword' => $keyword,
            ];
            
        
        return redirect()->route('search.post_search_result')->withInput($values);
    }
    
    public function post_search_result()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        }
        
        $key_tags = old('key_tags');
        if (isset($key_tags)) {
            session()->put('search_tags', $key_tags);
        }
        
        if (session()->has('search_tags')) {
            $search_tags = session()->get('search_tags');
            
            $keyword = implode('/', $search_tags);
            
            $posts = [];
            foreach ($search_tags as $search_tag) {
                $search_post_ids = Post_tag::where('tag_name', $search_tag)->get();
                foreach ($search_post_ids as $search_post_id) {
                    $search_post = Post::where('post_id', $search_post_id->post_id)->first();
                    
                    $post_id_check = array_column($posts, 'post_id');
                    $key = array_search($search_post->post_id, $post_id_check);

                    if ($key == null) {
                        $tags = [];
                        $postTags = Post_tag::where('post_id', $search_post->post_id)->get();
                        foreach ($postTags as $postTag) {
                            array_push($tags, $postTag->tag_name);
                        }
                        $search_post['tags'] = $tags;
                        
                        $post_user = User::where('user_id', $search_post->user_id)->first();
                        $search_post['user_name'] = $post_user->user_name;
                        $search_post['user_icon'] = $post_user->user_icon;
                        
                        $good_nums = Good::where('post_id', $search_post->post_id)->get();
                        $good_array = [];
                        foreach ($good_nums as $good_num) {
                            array_push($good_array, $good_num);
                        }
                        
                        $search_post['good'] = count($good_array);
                        
                        $save_check = Save::where('post_id', $search_post->post_id)->where('user_id', $user->user_id)->first();
                        if (isset($save_check)) {
                            $search_post['save'] = 1;
                        } else {
                            $search_post['save'] = 0;
                        }

                        array_push($posts, $search_post);    
                    }
                    
                }
            }
            
            $date  = array_column($posts, 'post_date');
            $time  = array_column($posts, 'post_time');
            array_multisort($posts, SORT_DESC, $date, $posts, SORT_DESC, $time);
            
            $posts_num = count($posts);
            
            $tag_flag = 1;
            
            
            session()->put('search_tags_store', $search_tags);
            session()->forget('search_tags');
            
            return view('searches.post_search', compact('user', 'keyword', 'posts', 'posts_num', 'tag_flag')); 
        }
        
        $keyword = old('keyword');
        
        if (isset($keyword)) {
            
            $posts = [];
            
            $keyword_posts = Post::where('post_title', 'like', "%$keyword%")->orWhere('post_content', 'like', "%$keyword%")->get();
            foreach ($keyword_posts as $keyword_post) {
                $tags = [];
                $postTags = Post_tag::where('post_id', $keyword_post->post_id)->get();
                foreach ($postTags as $postTag) {
                    array_push($tags, $postTag->tag_name);
                }
                $keyword_post['tags'] = $tags;
                
                $post_user = User::where('user_id', $keyword_post->user_id)->first();
                $keyword_post['user_name'] = $post_user->user_name;
                $keyword_post['user_icon'] = $post_user->user_icon;
                
                $good_nums = Good::where('post_id', $keyword_post->post_id)->get();
                $good_array = [];
                foreach ($good_nums as $good_num) {
                    array_push($good_array, $good_num);
                }
                
                $keyword_post['good'] = count($good_array);
                
                $save_check = Save::where('post_id', $keyword_post->post_id)->where('user_id', $user->user_id)->first();
                if (isset($save_check)) {
                    $keyword_post['save'] = 1;
                } else {
                    $keyword_post['save'] = 0;
                }
                
                array_push($posts, $keyword_post);
            }
            
            $date  = array_column($posts, 'post_date');
            $time  = array_column($posts, 'post_time');
            array_multisort($posts, SORT_DESC, $date, $posts, SORT_DESC, $time);
            
            $posts_num = count($posts);
            
            // session()->forget('search_tags');
            
            return view('searches.post_search', compact('user', 'keyword', 'posts', 'posts_num'));    
        } else {
            return redirect()->route('timeline.index')->with('message', 'キーワードを入力してください');
        }
        
    }
    
    public function search_tag_store(Request $request)
    {
        $raw = file_get_contents('php://input'); // POSTされた生のデータを受け取る
        $data = json_decode($raw); // json形式をphp変数に変換
        
        // やりたい処理
        session()->put('search_tags', $data);
        

        $res = 'Complete';
        // $res = $data;
        echo json_encode($res);
    }
    
    public function post_tag_search()
    {
        return redirect()->route('search.post_search_result');
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
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
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
