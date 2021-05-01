<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePasswordRequest;

class SetPasswordController extends Controller
{
    public function create()
    {
        return view('auth.set-password');
    }

    public function store(StorePasswordRequest $request)
    {
        auth()->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('home')->with('status', 'Password set successful');
    }
}
