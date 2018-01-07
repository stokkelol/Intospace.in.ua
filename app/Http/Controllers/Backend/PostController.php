<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Band;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Support\Images\ImageSaver;
use App\Support\Statuses\StatusChanger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Flash;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Tag
     */
    protected $tag;

    /**
     * @var Band
     */
    protected $band;

    /**
     * PostController constructor.
     *
     * @param Post $post
     * @param Category $category
     * @param Tag $tag
     * @param Band $band
     */
    public function __construct(
        Post $post,
        Category $category,
        Tag $tag,
        Band $band
    ) {
        $this->post = $post;
        $this->category = $category;
        $this->tag = $tag;
        $this->band = $band;
    }

    /**
     * backend.posts.index
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $posts = (new Post)->recent()->newQuery();

        if ($request->has('status')) {
            $posts = $this->post->byStatus($request->get('status'));
        }
        if ($request->exists('orderby')) {
            $posts = $this->post->with('category', 'user')->orderBy('published_at', 'asc');
        }
        if ($request->has('search')) {
            $posts = $this->post->bySearchQuery($request->get('search'));
        }

        //$posts = $this->_post->recent()->paginate(15);
        $posts = $posts->with('user', 'category')->paginate(15);

        $data = [
            'posts' => $posts,
            'categories' => $this->category->all(),
        ];

        return view('backend.posts.index', $data);
    }

    /**
     * backend.posts.create
     *
     * @return View
     */
    public function create(): View
    {
        $data = [
            'bands' => $this->band->all(),
            'categories' => $this->category->all(),
            'save_url' => route('backend.posts.store'),
            'tags' => $this->tag->pluck('tag', 'id')
        ];

        return view('backend.posts.create', $data);
    }

    /**
     * @param StorePostRequest $request
     * @param null $post_id
     * @return mixed
     * @return RedirectResponse
     */
    public function store(StorePostRequest $request, ImageSaver $imageSaver, $post_id = null): RedirectResponse
    {
        $post = $this->storeOrUpdatePost($request, $post_id = null);

        if ($request->hasFile('img')) {
            $imageSaver->saveCover('upload/covers/', $request->file('img'));
            $post->img = $request->file('img')->getClientOriginalName();
            $post->img_thumbnail = 'thumbnail_' . $request->file('img')->getClientOriginalName();
        }

        if ($request->hasFile('logo')) {
            $imageSaver->saveLogo('upload/logos/', $request->file('logo'));
            $post->logo = $request->file('logo')->getClientOriginalName();
        }

        $post->published_at = $request->input('published_at');
        //$post->published_at = Carbon::now();
        $post->save();
        $this->syncTags($post, $request->input('tagList'));

        flash()->message('Post created!');

        return redirect()->route('backend.posts.edit', ['post_id' => $post->id]);
    }

    /**
     * @param $post_id
     * @return View
     */
    public function show($post_id): View
    {
        $post = $this->post->findOrFail($post_id);
        $data = [
            'post' => $post,
        ];
        return view('backend.posts.show', $data);
    }

    /**
     * @param $post_id
     * @return View
     */
    public function edit($post_id): View
    {
        $data = [
            'post' => $this->post->find($post_id),
            'bands' => $this->band->all(),
            'categories' => $this->category->all(),
            'tags' => $this->tag->pluck('tag', 'id')
        ];

        return view('backend.posts.edit', $data);
    }

    /**
     * @param $post_id
     * @return RedirectResponse
     */
    public function destroy($post_id): RedirectResponse
    {
        $post = $this->post->findOrFail($post_id);
        $post->destroy($post_id);

        return redirect('backend/posts');
    }

    /**
     * @param StorePostRequest $request
     * @param ImageSaver $imageSaver
     * @param $post_id
     * @return RedirectResponse
     */
    public function update(StorePostRequest $request, ImageSaver $imageSaver, $post_id): RedirectResponse
    {
        $post = $this->storeOrUpdatePost($request, $post_id);
        $post->resluggify();

        if ($request->hasFile('img')) {
            $imageSaver->saveCover('upload/covers/', $request->file('img'));
            $post->img = $request->file('img')->getClientOriginalName();
            $post->img_thumbnail = 'thumbnail_' . $request->file('img')->getClientOriginalName();
        }

        if ($request->hasFile('logo')) {
            $imageSaver->saveLogo('upload/logos/', $request->file('logo'));
            $post->logo = $request->file('logo')->getClientOriginalName();
        }

        $post->updated_at = $request->input('updated_at');
        $post->published_at = $request->input('published_at');
        //dd($post);
        $post->update();

        flash()->message('Post updated!');

        return redirect()->route('backend.posts.index');
    }

    /**
     * @param $post_id
     * @param $category_id
     * @return RedirectResponse
     */
    public function setCategory($post_id, $category_id): RedirectResponse
    {
        $category = $this->category->find($category_id);

        if (empty($category)) {
            return redirect()->back();
        }

        $post = $this->post->find($post_id);
        $post->category_id = $category_id;
        $post->save();

        return redirect()->back();
    }

    /**
     * Sync the list of tags
     * @param Post $post
     * @param array $tags
     * @return array
     */
    public function syncTags(Post $post, array $tags): array
    {
        $post->tags()->sync($tags);
    }

    /**
     * @param $post_id
     * @return RedirectResponse
     */
    protected function toDraft($post_id): RedirectResponse
    {
        $changer = new StatusChanger($this->post->find($post_id));
        $changer->setStatus($post_id, 'draft');

        return redirect()->back();
    }

    /**
     * @param $post_id
     * @return RedirectResponse
     */
    protected function toActive($post_id): RedirectResponse
    {
        $changer = new StatusChanger($this->post->find($post_id));
        $changer->setStatus($post_id, 'active');

        return redirect()->back();
    }

    /**
     * @param $post_id
     * @return RedirectResponse
     */
    protected function toDeleted($post_id): RedirectResponse
    {
        $changer = new StatusChanger($this->post->find($post_id));
        $changer->setStatus($post_id, 'deleted');

        return redirect()->back();
    }

    public function setPinnedStatus($post_id, $pinned)
    {
        $post = $this->post->findOrFail($post_id);
        $post->is_pinned = $pinned;
        $post->save();

        return $post;
    }

    /**
     * @param $post_id
     * @return RedirectResponse
     */
    public function toPinned($post_id): RedirectResponse
    {
        $this->setPinnedStatus($post_id, '1');
        flash()->message('Post is pinned');

        return redirect()->back();
    }

    /**
     * @param $post_id
     * @return RedirectResponse
     */
    public function toRegular($post_id): RedirectResponse
    {
        $this->setPinnedStatus($post_id, '0');
        flash()->message('Post is unpinned');

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $post_id
     * @return Post
     */
    private function storeOrUpdatePost(Request $request, $post_id): Post
    {
        $post = $this->post->findOrNew($post_id);
        $post->user_id = Auth::user()->id;
        $post->title = $request->input('title');
        $post->year = preg_replace('/[^0-9]/', '', $request->input('title'));
        $post->band_id = $request->input('band_id');
        $post->excerpt = $request->input('excerpt');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
        $this->syncTags($post, $request->input('tagList'));
        $post->links = $request->input('links');
        $post->video = $request->input('video');
        $post->similar = $request->input('similar');

        return $post;
    }

    /**
     * @param Request $request
     * @param $post_id
     * @return View|null
     */
    public function postPreviewOnAjaxRequest(Request $request, $post_id): ?View
    {
        $post = $this->post->findOrFail($post_id);
        $preview = $post->content;

        if ($request->ajax()) {
            return view('backend.posts.show', $preview)->renderSection('content');
        }

        return null;
    }

    /**
     * @return RedirectResponse
     */
    public function getAllUpdated(): RedirectResponse
    {
        $posts = $this->post->all();

        foreach ($posts as $post) {
            $post->year = preg_replace('/[^0-9]/', '', $post->title);
            $post->update();
        }

        return redirect()->back();
    }
}
