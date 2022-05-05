<?php

namespace App\Http\Controllers;

use App\Save;
use Illuminate\Http\Request;

class SaveController extends Controller
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

    public function save_store(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $detail_post_id = $request->input('post_id');
        
        $values = [
            'post_id' => $detail_post_id,
            ];
            
        $save_check = Save::where('post_id', $detail_post_id)->where('user_id', $user->user_id)->first();
        if (isset($save_check)) {
            Save::where('post_id', $detail_post_id)->where('user_id', $user->user_id)->delete();
        } else {
            $save = new Save();
            $save->post_id = $detail_post_id;
            $save->user_id = $user->user_id;
            $save->save_datetime = date("Y.m.d H:i:s");
            $save->save();
        }
            
        if ($request->page == 'detail_post_page') {
            return redirect()->route('timeline.users_post')->withInput($values);    
        } elseif ($request->page == 'timeline_page') {
            return redirect()->route('timeline.index')->withInput($values);
        } elseif ($request->page == 'search_page') {
            $tag_flag = $request->input('tag_flag');
            
            if(isset($tag_flag)) {
                $search_tags_store = session()->get('search_tags_store');  
                $values = [
                    'keyword' => $request->input('keyword'),
                    'key_tags' => $search_tags_store,    
                    
                    ];
            } else {
                $values = [
                    'keyword' => $request->input('keyword'),
    
                    ];    
            }
            return redirect()->route('search.post_search_result')->withInput($values);
        } else {
            return redirect()->route('posts.save_post_show');
        }
        
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
     * @param  \App\Save  $save
     * @return \Illuminate\Http\Response
     */
    public function show(Save $save)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Save  $save
     * @return \Illuminate\Http\Response
     */
    public function edit(Save $save)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Save  $save
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Save $save)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Save  $save
     * @return \Illuminate\Http\Response
     */
    public function destroy(Save $save)
    {
        //
    }
}
