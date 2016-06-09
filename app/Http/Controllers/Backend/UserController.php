<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use View;
use Hash;
use Redirect;

class UserController extends Controller
{
    /**
     * User controller
     */

     protected $hidden = [
       'password'
     ];

    public function index(User $_user)
    {

        $users = $_user->all();

        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        $data = [
            'title' =>  'Create new user',
            'url' =>    route('backend.users.store'),
        ];
        return view('backend.users.user', $data);
    }

    public function store(User $_user, Request $request, $user_id = 0)
    {
      $user = $_user->findOrFail($user_id);
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->password = Hash::make($request->input('password'));
      //dd($user->email);
      $user->save();

      return Redirect::route('backend.users.index');
    }

    public function edit(User $_user, $user_id)
    {
      $user = $_user->findOrNew($user_id);

      return view('backend.users.edit', compact('user'));
    }

    public function update(User $_user, Request $request, $user_id)
    {
        $user = $_user->findOrNew($user_id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        //$user->role = $request->input('role');
        //dd($user);
        $user->update();

        return Redirect::route('backend.users.index');
    }

    public function destroy($user_id)
    {

    }
}
