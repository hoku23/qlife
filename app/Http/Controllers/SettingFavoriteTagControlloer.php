<?php

namespace App\Http\Controllers;

use App\Favorite_tag;
use Illuminate\Http\Request;

class SettingFavoriteTagControlloer extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $newFavTags = [];
        
        $fav_tags = Favorite_tag::where('user_id', $user->user_id)->get();
        foreach ($fav_tags as $fav_tag) {
            array_push($newFavTags, $fav_tag->tag_name);
        }
        
        $json_array = json_encode($newFavTags);
        $param_json = json_encode($newFavTags);
        
        return view('settings.setting_favTags', compact('user', 'param_json'));
    }
    
    public function store_tags(Request $request)
    {
        $raw = file_get_contents('php://input'); // POSTされた生のデータを受け取る
        $data = json_decode($raw); // json形式をphp変数に変換
        
        // やりたい処理
        
        $user = session()->get('user');
        $user_id = $user->user_id;
        
        $favTags_check = Favorite_tag::where('user_id', $user_id)->first();
        
        if (isset($favTags_check)) {
            Favorite_tag::where('user_id', $user_id)->delete();
        }
        
        foreach ($data as $tag) {
            $fav_tag = new Favorite_tag();
            $fav_tag->user_id = $user_id;
            $fav_tag->tag_name = $tag;
            $fav_tag->save();
        }
        

        $res = 'Complete';
        // $res = $data;
        echo json_encode($res);
    }
    
    public function redirect() {
        return redirect()->route('settingFavoriteTag.index')->with('message', 'お気に入りタグを保存しました');
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
     * @param  \App\Favorite_tag  $favorite_tag
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite_tag $favorite_tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favorite_tag  $favorite_tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite_tag $favorite_tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite_tag  $favorite_tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite_tag $favorite_tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite_tag  $favorite_tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite_tag $favorite_tag)
    {
        //
    }
}
