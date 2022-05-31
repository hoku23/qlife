<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    public function index()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        return view('privacys.index', compact('user'));
    }
}
