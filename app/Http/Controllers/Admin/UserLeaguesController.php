<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\User;
use App\League;

class UserLeaguesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
	$this->middleware( [ 'auth', 'admin' ] );
    }
 
    /**
     * Display a listing of the resource.
     *
     * @param	\Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.userleagues.index')->with( 'users', User::paginate() );
    }
 
    /**
     * Edit leagues of this user
     *
     * @param	\App\User
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.userleagues.edit')->with([
        	'user'		=> $user,
        	'leagues'	=> League::paginate(),
        ]);
    }
 
    /**
     * Attach league of this user
     *
     * @param	\App\User
     * @param	\App\League
     *
     * @return \Illuminate\Http\Response
     */
    public function attach(User $user, League $league)
    {
    	$user->leagues()->attach( $league->id );
    	
    	return redirect()->back();
    }
 
    /**
     * Detach league of this user
     *
     * @param	\App\User
     * @param	\App\League
     *
     * @return \Illuminate\Http\Response
     */
    public function detach(User $user, League $league)
    {
    	$user->leagues()->detach( $league->id );
    	
    	return redirect()->back();
    }
}
