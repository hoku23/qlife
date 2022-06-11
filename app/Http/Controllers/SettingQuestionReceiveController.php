<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SettingQuestionReceiveController extends Controller
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
        return view('settings.setting_questionReceive', compact('user'));
    }
    
    public function store_questionReceive(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        $input = $request->input('questionReceive');
        if ($input == 'yes') {
            $value = 1;
        } else {
            $value = 0;
        }
        
        if (isset($input)) {
            $change_user = User::where('user_id', $user->user_id)->first();
            $change_user->question_receive = $value;
            $change_user->save();
            session()->put('user', $change_user);
            
            return redirect()->route('settingQuestionReceive.index')->with('message', '質問受け取り設定が保存されました');
            
        } else {
            return redirect()->route('settingQuestionReceive.index')->with('message', '質問受け取り設定が入力されていません');   
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
