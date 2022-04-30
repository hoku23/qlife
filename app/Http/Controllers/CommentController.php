<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Answer_comment;
use Illuminate\Http\Request;

class CommentController extends Controller
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

    public function comment_store(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        }
        
        $content = $request->input('comment');
        $post_id = $request->input('post_id');
        
        $comment_num = Comment::all()->count();
        $comment_path = $comment_num + 1;
        $path = "$post_id/$comment_path/";
        
        $search = "/";
        
        $str_first_point = strpos($path, $search);
        $str_second_point = strpos($path, $search, $str_first_point+1 );
        
        $cut_str = substr($path, 0, $str_second_point);
        $r_id = substr($cut_str, $str_first_point+1);
        
        $p_id_elem = substr($path, $str_first_point+1);
        $p_id_cut_last = substr($p_id_elem, 0, strlen($p_id_elem)-1);
        
        $p_first_point = strrpos($p_id_cut_last, $search);
        $p_second_point = strrpos($p_id_cut_last, $search);

        $p_id_cut_elem = substr($p_id_cut_last, 0, $p_first_point);
        
        if (strpos($p_id_cut_elem, '/') === false) {
            $p_id = $p_id_cut_elem;
        } else {
            $p_cut_point = strrpos($p_id_cut_elem, $search);
        
            $p_id_check = substr($p_id_cut_elem, $p_cut_point+1);
            
            if (isset($p_id_check)) {
                $p_id = $p_id_check;
            } else {
                $p_id = 0;
            }   
        }
        
        if (isset($content)) {
            $comment = new Comment();
            $comment->content = $content;
            $comment->path = $path;
            $comment->parent_comment_id = intval($p_id);
            $comment->root_comment_id = intval($r_id);
            $comment->order = 1;
            $comment->user_id = $user->user_id;
            $comment->save();
        } 
        
        $values = [
            'post_id' => $post_id,
            ];
            
        return redirect()->route('timeline.users_post')->withInput($values);
    }
    
    public function reply_store(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        }
        
        $content = $request->input('comment');
        $comment_path = $request->input('comment_path');
        $comment_id = $request->input('comment_id');
        
        $comment_num = Comment::all()->count();
        $path_last = $comment_num + 1;
        $path = $comment_path.$path_last."/";
        
        $search = "/";
        
        $str_first_point = strpos($path, $search);
        $str_second_point = strpos($path, $search, $str_first_point+1 );
        
        $cut_str = substr($path, 0, $str_second_point);
        $r_id = substr($cut_str, $str_first_point+1);
        
        $p_id_elem = substr($path, $str_first_point+1);
        $p_id_cut_last = substr($p_id_elem, 0, strlen($p_id_elem)-1);
        
        $p_first_point = strrpos($p_id_cut_last, $search);
        $p_second_point = strrpos($p_id_cut_last, $search);

        $p_id_cut_elem = substr($p_id_cut_last, 0, $p_first_point);
        
        if (strpos($p_id_cut_elem, '/') === false) {
            $p_id = $p_id_cut_elem;
        } else {
            $p_cut_point = strrpos($p_id_cut_elem, $search);
        
            $p_id_check = substr($p_id_cut_elem, $p_cut_point+1);
            
            if (isset($p_id_check)) {
                $p_id = $p_id_check;
            } else {
                $p_id = 0;
            }   
        }
        
        $order_columns = Comment::where('parent_comment_id', $p_id)->orderBy('order', 'desc')->first();
        if (isset($order_columns)) {
            $order = $order_columns->order+1;
            
        } else {
            $parent_comment = Comment::where('path', $comment_path)->first();
            $order = $parent_comment->order+1;
        }
        
        // dd($order);
        
        $comments = Comment::where('order', '>=', intval($order))->increment('order');
        
        if (isset($content)) {
            $comment = new Comment();
            $comment->content = $content;
            $comment->path = $path;
            $comment->parent_comment_id = intval($p_id);
            $comment->root_comment_id = intval($r_id);
            $comment->order = intval($order);
            $comment->user_id = $user->user_id;
            $comment->save();
        } 
        
        $post_id = $request->input('post_id');
        $values = [
            'post_id' => $post_id,
            ];
            
        return redirect()->route('timeline.users_post')->withInput($values);
    }
    
    public function answer_comment_store(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        }
        
        $content = $request->input('comment');
        $answer_id = $request->input('answer_id');
        
        $comment_num = Answer_comment::all()->count();
        $comment_path = $comment_num + 1;
        $path = "$answer_id/$comment_path/";
        
        $search = "/";
        
        $str_first_point = strpos($path, $search);
        $str_second_point = strpos($path, $search, $str_first_point+1 );
        
        $cut_str = substr($path, 0, $str_second_point);
        $r_id = substr($cut_str, $str_first_point+1);
        
        $p_id_elem = substr($path, $str_first_point+1);
        $p_id_cut_last = substr($p_id_elem, 0, strlen($p_id_elem)-1);
        
        $p_first_point = strrpos($p_id_cut_last, $search);
        $p_second_point = strrpos($p_id_cut_last, $search);

        $p_id_cut_elem = substr($p_id_cut_last, 0, $p_first_point);
        
        if (strpos($p_id_cut_elem, '/') === false) {
            $p_id = $p_id_cut_elem;
        } else {
            $p_cut_point = strrpos($p_id_cut_elem, $search);
        
            $p_id_check = substr($p_id_cut_elem, $p_cut_point+1);
            
            if (isset($p_id_check)) {
                $p_id = $p_id_check;
            } else {
                $p_id = 0;
            }   
        }
        
        if (isset($content)) {
            $comment = new Answer_comment();
            $comment->content = $content;
            $comment->path = $path;
            $comment->parent_comment_id = intval($p_id);
            $comment->root_comment_id = intval($r_id);
            $comment->order = 1;
            $comment->user_id = $user->user_id;
            $comment->save();
        } 
        
        $values = [
            'answer_id' => $answer_id,
            ];
            
        return redirect()->route('answer.users_answer')->withInput($values);
    }
    
    public function answer_reply_store(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        }
        
        $content = $request->input('comment');
        $comment_path = $request->input('comment_path');
        $comment_id = $request->input('comment_id');
        
        $comment_num = Answer_comment::all()->count();
        $path_last = $comment_num + 1;
        $path = $comment_path.$path_last."/";
        
        $search = "/";
        
        $str_first_point = strpos($path, $search);
        $str_second_point = strpos($path, $search, $str_first_point+1 );
        
        $cut_str = substr($path, 0, $str_second_point);
        $r_id = substr($cut_str, $str_first_point+1);
        
        $p_id_elem = substr($path, $str_first_point+1);
        $p_id_cut_last = substr($p_id_elem, 0, strlen($p_id_elem)-1);
        
        $p_first_point = strrpos($p_id_cut_last, $search);
        $p_second_point = strrpos($p_id_cut_last, $search);

        $p_id_cut_elem = substr($p_id_cut_last, 0, $p_first_point);
        
        if (strpos($p_id_cut_elem, '/') === false) {
            $p_id = $p_id_cut_elem;
        } else {
            $p_cut_point = strrpos($p_id_cut_elem, $search);
        
            $p_id_check = substr($p_id_cut_elem, $p_cut_point+1);
            
            if (isset($p_id_check)) {
                $p_id = $p_id_check;
            } else {
                $p_id = 0;
            }   
        }
        
        $order_columns = Answer_comment::where('parent_comment_id', $p_id)->orderBy('order', 'desc')->first();
        if (isset($order_columns)) {
            $order = $order_columns->order+1;
            
        } else {
            $parent_comment = Answer_comment::where('path', $comment_path)->first();
            $order = $parent_comment->order+1;
        }
        
        // dd($order);
        
        $comments = Answer_comment::where('order', '>=', intval($order))->increment('order');
        
        if (isset($content)) {
            $comment = new Answer_comment();
            $comment->content = $content;
            $comment->path = $path;
            $comment->parent_comment_id = intval($p_id);
            $comment->root_comment_id = intval($r_id);
            $comment->order = intval($order);
            $comment->user_id = $user->user_id;
            $comment->save();
        } 
        
        $answer_id = $request->input('answer_id');
        $values = [
            'answer_id' => $answer_id,
            ];
            
        return redirect()->route('answer.users_answer')->withInput($values);
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
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
