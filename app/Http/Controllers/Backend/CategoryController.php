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
    protected $_category;

    public function __construct(Category $category)
    {
        $this->_category = $category;
    }

    public function index(Category $_category)
    {
        $categories = $_category->categoriesWithPostsCount();
        return view('backend.categories.index', compact('categories'));
    }

    public function create()
    {
        $data =[
            'title' =>  'Create New Category',
            'category'  =>  null,
            'save_url'  =>  route('backend.categories.store'),
        ];

        return view('backend.categories.category', $data);
    }

    public function store(Category $_category, Request $request, $category_id = null)
    {
        $category = $_category->findOrNew($category_id);

        //$category->user_id = Auth::user()->id;
        $category->title = $request->input('title');

        $category->save();
        Flash::message('Category created!');

        return redirect()->route('backend.categories.index');
    }

    public function show(Category $_category, $category_id)
    {
        $category = $_category->findOrFail($category_id);

        $data = [
            'title' =>  $category->title,
            'posts' =>  DB::table('posts')->where('category_id', $category_id)->get(),
        ];

        return view('backend.categories.show', $data);
    }

    public function edit(Category $_category, $category_id)
    {
        $category = $_category->findOrFail($category_id);
        //$category->user_id = Auth::user()->id;
        $data = [
            'categories'    =>  $_category->all(),
            'category'      =>  $category,
            'title'         =>  $category->id.': Edit Category',
        ];

        return view('backend.categories.edit', $data);
    }

    public function destroy(Category $_category, $category_id)
    {
        $category = $_category->findOrFail($category_id);
        Category::destroy($category_id);

        Flash::message('Category deleted!');
        return redirect('backend/posts');
    }

    public function update(Category $_category, Request $request, $category_id)
    {
        $category = $_category->findOrNew($category_id);
        //$category->user_id = Auth::user()->id;
        $category->title = $request->input('title');
        $category->resluggify();
        $category->update();


        Flash::message('Category updated!');
        return redirect()->route('backend.categories.index');
    }
}
