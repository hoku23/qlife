<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;

class RegisterController extends Controller
{
    private $validator = [
            'user_id' => 'required|string|unique:users',
            'password' =>'required|string',
            'confirm_password' => 'required|same:password',
            'user_name' => 'required|string',
            'email' => 'required|string|unique:users'
        ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('registers.index');
    }
    
    public function confirm(Request $request)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, $this->validator);
        
        if ($validator->fails()){
            return redirect()->route('registers.index')
                             ->withErrors($validator)
                             ->withInput($input);
        } else {
            return view('registers.confirm', ['input' => $input]);
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
        $action = $request->input('action');
        $input = $request->except('action');
        
        if ($action == '登録') {
            $user = new User();
        
            $user->user_id = $request->input('user_id');
            $user->password = $request->input('password');
            $user->user_name = $request->input('user_name');
            $user->email = $request->input('email');
            $user->save();
            
            return redirect()->route('registers.show', ['id' => $user->id]);
        } else {
            return redirect()->route('registers.index')->withInput($input);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('registers.complete', compact('user'));
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
