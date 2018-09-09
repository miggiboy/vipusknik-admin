<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\User\{
    StoreSessionRequest
};

use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except(['destroy']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.sessions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSessionRequest $request)
    {
        
        if (! Auth::attempt(request(['email', 'password']), $request->has('remember'))
        ) {
            $request->flashOnly('email');

            return back()->withMessage('Логин или пароль не верны');
        }

        if (Auth::user()->hasNoAccess()) {
            Auth::logout();
            return redirect()->route('login')->withMessage('Вам еще не предоставлен доступ');
        }
        
        if (Auth::user()->hasRole('college')) {
            $institution = Auth::user()->institutions[0];
            return redirect()->route('institutions.show', [$institution->type, $institution]);
        }
        
        
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        Auth::logout();

        return redirect()->home();
    }
}
