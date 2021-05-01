<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePasswordRequest;

class SetPasswordController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.set-password');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\StorePasswordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePasswordRequest $request)
    {
        auth()->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('home')->with('status', 'Password set successful');
    }
}
