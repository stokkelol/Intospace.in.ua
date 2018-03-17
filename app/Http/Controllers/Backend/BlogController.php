<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::query()->with('user')->paginate(15);

        return view('backend.blogs.index', compact('blogs'));
    }

    public function show(Request $request, $id)
    {
        $blog = Blog::query()->findOrFail($id);

        return view('backend.blogs.show', compact('blog'));
    }

    public function create()
    {
        $data = [
            'save_url' => route('backend.blogs.store'),
        ];
        return view('backend.blogs.create', $data);
    }

    public function destroy($id)
    {
        Blog::query()->findOrFail($id);

    }

    public function update(StoreBlogRequest $request, $id)
    {
        Blog::query()->findOrNew($id);
    }

    public function store(StoreBlogRequest $request)
    {
        $blog = $this->storeOrUpdateBlog($request, $blog_id = null);

        //dd($request->input('published_at'));
        $blog->published_at = $request->input('published_at');
        $blog->save();

        Flash::message('blog created!');
        return redirect()->route('backend.blogs.edit', ['blog_id' => $blog->id]);
    }

    public function edit($blog_id)
    {
        $data = [
            'blog' => $this->blog->find($blog_id),
        ];

        return view('backend.blogs.edit', $data);
    }

    public function storeOrUpdateBlog(Request $request, $blog_id)
    {
        $blog = Blog::query()->findOrNew($blog_id);
        $blog->user_id = Auth::user()->id;
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');

        return $blog;
    }
}
