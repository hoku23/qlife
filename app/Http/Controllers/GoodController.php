<?php

namespace App\Http\Controllers;

use App\Good;
use Illuminate\Http\Request;

class GoodController extends Controller
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
    
    public function good_store(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        }
        
        $detail_post_id = $request->input('post_id');
        
        $values = [
            'post_id' => $detail_post_id,
            ];
            
        $good_check = Good::where('post_id', $detail_post_id)->where('user_id', $user->user_id)->first();
        if (isset($good_check)) {
            Good::where('post_id', $detail_post_id)->where('user_id', $user->user_id)->delete();
        } else {
            $good = new Good();
            $good->post_id = $detail_post_id;
            $good->user_id = $user->user_id;
            $good->save();
        }
            
        return redirect()->route('timeline.users_post')->withInput($values);
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
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function show(Good $good)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function edit(Good $good)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Good $good)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function destroy(Good $good)
    {
        //
    }
}
