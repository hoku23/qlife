<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
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
        $user = session()->get('user');
        return view('settings.setting_user', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function user_name_change(Request $request) 
    {
        
        $user = session()->get('user');
        $newUser_name = $request->input('newUser_name');
        
        if (isset($newUser_name)){
            $change_user = User::where('user_id', $user->user_id)->first();
            $change_user->user_name = $newUser_name;
            $change_user->save();
            
            session()->put('user', $change_user);
            return redirect()->route('settingUser.index');
        } else {
            return redirect()->route('settingUser.index')->with('message', '新しいユーザーネームが入力されていません');
        }
    } 
    
    public function user_email_change(Request $request) 
    {
        $user = session()->get('user');
        $newUser_email = $request->input('newUser_email');
        
        if (isset($newUser_email)){
            $email_check = User::where('email', $newUser_email)->first();
            if (empty($email_check)) {
                $change_user = User::where('user_id', $user->user_id)->first();
                $change_user->email = $newUser_email;
                $change_user->save();
                session()->put('user', $change_user);
                return redirect()->route('settingUser.index');
            } else {
                return redirect()->route('settingUser.index')->with('message', 'このメールアドレスはすでに使われています');
            }    
        } else {
            return redirect()->route('settingUser.index')->with('message', '新しいメールアドレスが入力されていません');   
        }
    }
    
    public function user_password_change(Request $request)
    {
        $user = session()->get('user');
        $user_password = $request->input('user_password');
        $newUser_password = $request->input('newUser_password');
        $newUser_password_confirm = $request->input('newUser_password_confirm');
        $password = $user->password;
        
        if (isset($user_password)) {
            if (isset($newUser_password)) {
                if (isset($newUser_password_confirm)) {
                    if (password_verify($user_password, $password)) {
                        if ($newUser_password == $newUser_password_confirm) {
                            $change_user = User::where('user_id', $user->user_id)->first();
                            $change_user->password = Hash::make($newUser_password);
                            $change_user->save();
                            session()->put('user', $change_user);
                            return redirect()->route('settingUser.index');
                        } else {
                            return redirect()->route('settingUser.index')->with('message', '確認用パスワードが一致していません');
                        }
                    } else {
                        return redirect()->route('settingUser.index')->with('message', '現在のパスワードが違います');    
                    }
                } else {
                    return redirect()->route('settingUser.index')->with('message', '確認用パスワードが入力されていません');
                }
            } else {
                return redirect()->route('settingUser.index')->with('message', '新しいパスワードが入力されていません');
            }
        } else {
            return redirect()->route('settingUser.index')->with('message', '現在のパスワードが入力されていません');
        }
    }
    
    public function user_icon_change(Request $request)
    {
        $user = session()->get('user');
        
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
