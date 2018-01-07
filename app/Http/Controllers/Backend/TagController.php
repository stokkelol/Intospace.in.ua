<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Models\PostTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\View\View;
use Redirect;
use DB;
use Cache;
use App\Http\Requests;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class TagController
 *
 * @package App\Http\Controllers\Backend
 */
class TagController extends Controller
{
    /**
     * @var Tag
     */
    protected $tag;

    /**
     * TagController constructor.
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $tags = $this->tag->latest()->paginate(15);

        return view('backend.tags.index', compact('tags'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $data = [
            'tags' => $this->tag->all(),
            'title' => 'Create new tag',
            'save_url' => route('backend.tags.store'),
        ];

        return view('backend.tags.create', $data);
    }

    /**
     * @param Request $request
     * @param null $tag_id
     * @return RedirectResponse
     */
    public function store(Request $request, $tag_id = null): RedirectResponse
    {
        $tag = $this->tag->findOrNew($tag_id);
        $tag->tag = $request->input('tagtitle');
        $tag->save();

        return redirect()->route('backend.tags.index');
    }

    /**
     * @param PostTag $posttag
     * @param $tag_id
     * @return RedirectResponse
     */
    public function remove(PostTag $posttag, $tag_id): RedirectResponse
    {
        $tag = $this->tag->findOrFail($tag_id);
        $tag->destroy();
        $posttag->where(['tag_id' => $tag_id])->delete();

        return redirect()->back();
    }

    /**
     * @param $tag_id
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function edit($tag_id): View
    {
        $tag = $this->tag->find($tag_id);

        $data = [
            'title' => $tag->id.': Edit Tag',
            'tags' => $this->tag->all(),
            'tag' => $tag,
        ];

        $tag->update();

        return view('backend.tags.edit', $data);
    }

    /**
     * @param Request $request
     * @param $tag_id
     * @return RedirectResponse
     */
    public function update(Request $request, $tag_id): RedirectResponse
    {
        $tag = $this->tag->find($tag_id);
        $tag->tag = $request->input('tagtitle');
        $tag->resluggify();
        $tag->update();

        return redirect()->route('backend.tags.index');
    }

    /**
     * @param Post $post
     * @param $slug
     * @return View
     */
    public function show(Post $post, $slug): View
    {
        $tag = $this->tag->findBySlug($slug);

        $posts = $post->with('tags', 'category')->whereHas('tags', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->latest()->paginate(10);

        return view('backend.tags.show', compact('tag', 'posts'));
    }
}
