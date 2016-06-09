<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Redirect;
use DB;
use Cache;
use App\Http\Requests;

class TagController extends Controller
{
    protected $_tag;

    public function __construct(Tag $_tag)
    {
        $this->_tag = $_tag;
    }

    public function index(Tag $_tag)
    {
        $tags = $_tag->latest()->paginate(15);
        return view('backend.tags.index', compact('tags'));
    }

    public function create(Tag $_tag)
    {
        $data = [
            'tags'      =>  $_tag->all(),
            'title'     =>  'Create new tag',
            'save_url'  =>  route('backend.tags.store'),
        ];

        return view('backend.tags.tag', $data);
    }

    public function store(Tag $_tag, Request $request, $tag_id = null)
    {
        $tag = $_tag->findOrNew($tag_id);
        $tag->tag = $request->input('tagtitle');
        $tag->save();

        return Redirect::route('backend.tags.index');
    }

    public function remove(Tag $_tag, PostTag $_posttag, $tag_id)
    {
        $_tag->destroy($tag_id);
        $_posttag->where(['tag_id' => $tag_id])->delete();

        return Redirect::back();
    }

    public function edit(Tag $_tag, $tag_id)
    {
        $tag = $_tag->find($tag_id);

        $data = [
            'title'     =>  $tag->id.': Edit Tag',
            'tags'      =>  $_tag->all(),
            'tag'       =>  $tag,
        ];

        $tag->update();

        return view('backend.tags.edit', $data);
    }

    public function update(Tag $_tag, Request $request, $tag_id)
    {
        $tag = $_tag->find($tag_id);
        //$category->user_id = Auth::user()->id;
        $tag->tag = $request->input('tagtitle');
        $tag->resluggify();
        $tag->update();

        return Redirect::route('backend.tags.index');
    }

    public function show(Tag $_tag, Post $_post, $slug)
    {
        $tag = $_tag->findBySlug($slug);

        $posts = $_post->with('tags', 'category')->whereHas('tags', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->latest()->paginate(10);

        return view('backend.tags.show', compact('tag', 'posts'));
    }
}
