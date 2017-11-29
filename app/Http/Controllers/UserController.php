<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Users\UserRepository;
use App\Repositories\Posts\PostRepository;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    protected $user;
    protected $post;

    /**
     * UserController constructor.
     * @param UserRepository $user
     * @param PostRepository $post
     */
    public function __construct(UserRepository $user, PostRepository $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show()
    {
        if (!Auth::user()) {
            return redirect('/');
        }

        $user_id = Auth::id();

        $data = [
            'user' => $this->user->getUser(),
            'posts' => $this->post->getPostsByUserId($user_id)->get()
        ];
        return view('frontend.users.show', $data);
    }
}
