<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Hash;

class UserController extends Controller
{
    /**
     * User controller
     */

     protected $user;

     public function __construct(User $user)
     {
        $this->user = $user;
     }

     protected $hidden = [
       'password'
     ];

    public function index()
    {

        $users = $this->user->all();

        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        $data = [
            'title' =>  'Create new user',
            'url' =>    route('backend.users.store'),
        ];
        return view('backend.users.create', $data);
    }

    public function store(Request $request, $user_id = 0)
    {
      $user = $this->user->findOrFail($user_id);
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->password = Hash::make($request->input('password'));
      //dd($user->email);
      $user->save();

      return redirect()->route('backend.users.index');
    }

    public function edit($user_id)
    {
      $user = $this->user->findOrNew($user_id);

      return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, $user_id)
    {
        $user = $this->user->findOrNew($user_id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        //$user->role = $request->input('role');
        //dd($user);
        $user->update();

        return redirect()->route('backend.users.index');
    }
}
