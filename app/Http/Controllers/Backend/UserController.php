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

    public function index()
    {

        $users = User::all();

        return View::make('backend.users.index', compact('users'));
    }

    public function create()
    {
        $data = [
            'title' =>  'Create new user',
            'url' =>    route('backend.users.store'),
        ];
        return View::make('backend.users.user', $data);
    }

    public function store(Request $request)
    {
      $user = new User();
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->password = Hash::make($request->input('password'));
      //dd($user->email);
      $user->save();

      return Redirect::back();
    }

    public function edit($user_id)
    {
      $user = User::findOrNew($user_id);

      $user->update();

      return Redirect::back();
    }

    public function update(Request $request, $user_id)
    {

    }

    public function destroy($user_id)
    {

    }
}
