<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Rules\Hankaku;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    private $validator = [
            'user_id' => 'required|string|unique:users|max:30',
            'password' =>'required|string|max:20',
            'confirm_password' => 'required|same:password',
            'user_name' => 'required|string|max:50',
            'email' => 'required|string|unique:users|max:256|email'
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
        
        // $validator = Validator::make($input, $this->validator);
        $validator = Validator::make($input, ['user_id' => ['required', 'string', 'unique:users', new Hankaku, 'max:30'],
                                              'password' => ['required', 'string', new Hankaku, 'max:20'],
                                              'confirm_password' => ['required', 'same:password'],
                                              'user_name' => ['required', 'string', 'max:50'],
                                              'email' => ['required', 'string', 'unique:users', 'max:256', 'email']
        ]);
        
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
            $user->password = Hash::make($request->input('password'));
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
