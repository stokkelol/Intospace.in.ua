<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show()
    {
        if (!Auth::user()) {
            return redirect('/');
        }

        $user = User::query()->find(Auth::id());

        $data = [
            'user' => $user,
            'posts' => $user->posts
        ];
        return view('frontend.users.show', $data);
    }
}
