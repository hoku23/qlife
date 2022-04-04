<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{
    private $validator = [
            'user_id' => 'required|string',
            'password' =>'required|string',
        ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('logins.index');
    }
    
    public function auth(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, $this->validator);

        if ($validator->fails()){
            return redirect()->route('logins.index')
                             ->withErrors($validator);
        } else {
            $inputUser_id = $request->input('user_id');
            $users = User::where('user_id', $inputUser_id)->get();
            
            foreach ($users as $user);
            
            $password = $user->password;
            $inputPassword =$request->input('password');
            
            $user_name = $user->user_name;
            
            if ($password == $inputPassword) {
                return view('homes.index', compact('user'));
            } else {
                return redirect()->route('logins.index')->with('message', 'ユーザーIDまたはパスワードが違います');
            }
        }
    }
    
    public function logout()
    {
         return view('logins.logout');
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
    public function show($user_id)
    {
   
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
