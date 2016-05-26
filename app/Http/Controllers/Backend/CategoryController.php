<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Post;
use Auth;
use Flash;
use Input;
use Redirect;
use View;
use DB;
use App\Http\Requests;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::getInstance()->categoriesWithPostsCount();
        return View::make('backend.categories.index', compact('categories'));
    }

    public function create()
    {
        $data =[
            'title' =>  'Create New Category',
            'category'  =>  null,
            'save_url'  =>  route('backend.categories.store'),
        ];

        return View::make('backend.categories.category', $data);
    }

    public function store(Request $request, $category_id = null)
    {
        $category = Category::findOrNew($category_id);

        //$category->user_id = Auth::user()->id;
        $category->title = $request->input('title');

        $category->save();
        Flash::message('Category created!');

        return Redirect::route('backend.categories.index');
    }

    public function show($category_id)
    {
        $category = Category::findOrFail($category_id);

        $data = [
            'title' =>  $category->title,
            'posts' =>  DB::table('posts')->where('category_id', $category_id)->get(),
        ];

        return View::make('backend.categories.show', $data);
    }

    public function edit($category_id)
    {
        $category = Category::findOrFail($category_id);
        //$category->user_id = Auth::user()->id;
        $data = [
            'categories'    =>  Category::all(),
            'category'          =>  $category,
            'title'         =>  $category->id.': Edit Category',
        ];

        return View::make('backend.categories.edit', $data);
    }

    public function destroy($category_id)
    {
        $category = Post::findOrFail($category_id);
        Post::destroy($category_id);

        Flash::message('Category deleted!');
        return redirect('backend/posts');
    }

    public function update(Request $request, $category_id)
    {
        $category = Category::findOrNew($category_id);
        //$category->user_id = Auth::user()->id;
        $category->title = $request->input('title');
        $category->resluggify();
        $category->update();


        Flash::message('Category updated!');
        return Redirect::route('backend.categories.index');
    }
}
