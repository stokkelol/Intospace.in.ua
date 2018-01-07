<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Backend
 */
class UserController extends Controller
{
    /**
     * User controller
     */

     protected $user;

    /**
     * UserController constructor.
     *
     * @param User $user
     */
     public function __construct(User $user)
     {
        $this->user = $user;
     }

    /**
     * @var array
     */
     protected $hidden = [
       'password'
     ];

    /**
     * @return View
     */
    public function index(): View
    {
        $users = $this->user->all();

        return view('backend.users.index', compact('users'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $data = [
            'title' => 'Create new user',
            'url' => route('backend.users.store'),
        ];
        
        return view('backend.users.create', $data);
    }

    /**
     * @param Request $request
     * @param int $user_id
     * @return RedirectResponse
     */
    public function store(Request $request, $user_id = 0): RedirectResponse
    {
      $user = $this->user->findOrFail($user_id);
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->password = Hash::make($request->input('password'));
      $user->save();

      return redirect()->route('backend.users.index');
    }

    /**
     * @param $user_id
     * @return View
     */
    public function edit($user_id): View
    {
      $user = $this->user->findOrNew($user_id);

      return view('backend.users.edit', compact('user'));
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return RedirectResponse
     */
    public function update(Request $request, $user_id): RedirectResponse
    {
        $user = $this->user->findOrNew($user_id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->update();

        return redirect()->route('backend.users.index');
    }
}
