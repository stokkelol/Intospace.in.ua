<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use View;
use Redirect;
use DB;
use Cache;
use App\Http\Requests;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->paginate(15);
        return View::make('backend.tags.index', compact('tags'));
    }

    public function create()
    {
        $data = [
            'tags'  =>  Tag::all(),
            'title' =>  'Create new tag',
            'save_url'  =>  route('backend.tags.store'),
        ];

        return View::make('backend.tags.tag', $data);
    }

    public function store(Request $request)
    {
        $tag = new Tag();
        $tag->tag = $request->input('tagtitle');
        $tag->save();

        return Redirect::route('backend.tags.index');
    }

    public function remove($tag_id)
    {
        Tag::destroy($tag_id);
        PostTag::where(['tag_id' => $tag_id])->delete();

        return Redirect::back();
    }

    public function edit($tag_id)
    {
        $tag = Tag::find($tag_id);

        $data = [
            'title'         =>  $tag->id.': Edit Tag',
            'tags'    =>  Tag::all(),
            'tag'          =>  $tag,
        ];

        $tag->update();

        return View::make('backend.tags.edit', $data);
    }

    public function update(Request $request, $tag_id)
    {
        $tag = Tag::find($tag_id);
        //$category->user_id = Auth::user()->id;
        $tag->tag = $request->input('tagtitle');
        $tag->resluggify();
        $tag->update();

        return Redirect::route('backend.tags.index');
    }

    public function show($slug)
    {
        $tag = Tag::findBySlug($slug);

        $posts = Post::with('tags', 'category')->whereHas('tags', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->latest()->paginate(10);

        return View::make('backend.tags.show', compact('tag', 'posts'));
    }
}
