<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Post;
use Auth;
use Flash;
use DB;
use App\Http\Requests;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $categories = $this->category->categoriesWithPostsCount();

        return view('backend.categories.index', compact('categories'));
    }

    public function create()
    {
        $data =[
            'title' =>  'Create New Category',
            'category'  =>  null,
            'save_url'  =>  route('backend.categories.store'),
        ];

        return view('backend.categories.create', $data);
    }

    public function store(Request $request, $category_id = null)
    {
        $category = $this->category->findOrNew($category_id);

        //$category->user_id = Auth::user()->id;
        $category->title = $request->input('title');

        $category->save();
        flash()->message('Category created!');

        return redirect()->route('backend.categories.index');
    }

    public function show($category_id)
    {
        $category = $this->category->findOrFail($category_id);

        $data = [
            'title' =>  $category->title,
            'posts' =>  DB::table('posts')->where('category_id', $category_id)->get(),
        ];

        return view('backend.categories.show', $data);
    }

    public function edit($category_id)
    {
        $category = $this->category->findOrFail($category_id);
        //$category->user_id = Auth::user()->id;
        $data = [
            'categories'    =>  $this->_category->all(),
            'category'      =>  $category,
            'title'         =>  $category->id.': Edit Category',
        ];

        return view('backend.categories.edit', $data);
    }

    public function destroy($category_id)
    {
        $category = $this->category->findOrFail($category_id);
        Category::destroy($category_id);

        flash()->message('Category deleted!');

        return redirect('backend/posts');
    }

    public function update(Request $request, $category_id)
    {
        $category = $this->category->findOrNew($category_id);
        //$category->user_id = Auth::user()->id;
        $category->title = $request->input('title');
        $category->resluggify();
        $category->update();
        
        flash()->message('Category updated!');

        return redirect()->route('backend.categories.index');
    }
}
