<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Notifications\TenantInviteNotification;

class TenantController extends Controller
{
    protected $COMPANY_ROLE_ID;
    
    public function __construct()
    {
        $this->COMPANY_ROLE_ID = 2;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = User::where('role_id', $this->COMPANY_ROLE_ID)->get();

        return view('tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\StoreTenantRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTenantRequest $request)
    {
        $user = User::create($request->validated() + [
            'role_id' => $this->COMPANY_ROLE_ID, 
            'password' => '0123456789'
            ]);

        $url = URL::signedRoute('invitation', $user);
        $user->notify(new TenantInviteNotification($url));

        return redirect()->route('tenants.index');
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param  User $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit(User $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\UpdateTenantRequest
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTenantRequest $request, User $tenant)
    {
        $tenant->update($request->validated());

        return redirect()->route('tenants.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $tenant)
    {
        $tenant->delete();

        return redirect()->route('tenants.index');
    }


    /**
     * Authenticate User.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function invitation(User $user)
    {
        if(!request()->hasValidSignature() || $user->password != '0123456789')
        {
            abort(401);
        }

        auth()->login($user);

        return redirect()->route('home');
    }
}
