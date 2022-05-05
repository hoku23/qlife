<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use App\Rules\Hankaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingUserController extends Controller
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
        return view('settings.setting_user', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function user_name_change(Request $request) 
    {
        
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        $newUser_name = $request->input('new_user_name');
        
        $input = $request->all();
        $validator = Validator::make($input, ['new_user_name' => ['required', 'string', 'max:50']]);
        
        if ($validator->fails()){
            return redirect()->route('settingUser.index')
                             ->withErrors($validator);
        } else {
            $change_user = User::where('user_id', $user->user_id)->first();
            $change_user->user_name = $newUser_name;
            $change_user->save();
            
            session()->put('user', $change_user);
            return redirect()->route('settingUser.index');   
        }
    } 
    
    public function user_email_change(Request $request) 
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        $newUser_email = $request->input('email');
        
        $input = $request->all();
        $validator = Validator::make($input, ['email' => ['required', 'string', 'unique:users', 'max:256', 'email']]);
        
        if ($validator->fails()){
            return redirect()->route('settingUser.index')
                             ->withErrors($validator);
        } else {
            $change_user = User::where('user_id', $user->user_id)->first();
            $change_user->email = $newUser_email;
            $change_user->save();
            session()->put('user', $change_user);
            return redirect()->route('settingUser.index');
        }
    }
    
    public function user_password_change(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        $user_password = $request->input('user_password');
        $newUser_password = $request->input('new_password');
        $newUser_password_confirm = $request->input('new_password_confirm');
        $password = $user->password;
        
        if (isset($user_password)) {
            $input = $request->all();
            $validator = Validator::make($input, ['new_password' => ['bail', 'required', 'string', new Hankaku, 'max:20'],
                                                  'new_password_confirm' => ['bail', 'required', 'same:new_password']
            ]);
            
            if (password_verify($user_password, $password)) {
                if ($validator->fails()){
                return redirect()->route('settingUser.index')
                                 ->withErrors($validator);
                } else {
                    $change_user = User::where('user_id', $user->user_id)->first();
                    $change_user->password = Hash::make($newUser_password);
                    $change_user->save();
                    session()->put('user', $change_user);
                    return redirect()->route('settingUser.index');
                }
            } else {
                return redirect()->route('settingUser.index')->with('message', '現在のパスワードが違います');    
            }
        } else {
            return redirect()->route('settingUser.index')->with('message', '現在のパスワードが入力されていません');
        }
    }
    
    public function user_icon_change(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        if ($request->file('user_icon')) {
            $file_name = $request->input('file_name');
            $iconPath = $request->input('iconPath');
            $img = $request->file('user_icon')->storeAs('user_icons', $file_name, 'public');
            
            $change_user = User::where('user_id', $user->user_id)->first();
            $change_user->user_icon = $iconPath;
            $change_user->save();
            session()->put('user', $change_user);
            
            return redirect()->route('settingUser.index');
        } else { 
            
            return redirect()->route('settingUser.index')->with('message', '新しいアイコン画像が選択されていません');
        }
        
    }
    
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
