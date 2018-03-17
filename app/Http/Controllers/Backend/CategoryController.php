<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class CategoryController
 *
 * @package App\Http\Controllers\Backend
 */
class CategoryController extends Controller
{
    public function index()
    {
        $categories = (new Category())->categoriesWithPostsCount();

        return view('backend.categories.index', compact('categories'));
    }

    public function create()
    {
        $data = [
            'title' => 'Create New Category',
            'category' => null,
            'save_url' => route('backend.categories.store'),
        ];

        return view('backend.categories.create', $data);
    }

    public function store(Request $request, $category_id = null)
    {
        $category = Category::query()->findOrNew($category_id);

        $category->title = $request->input('title');

        $category->save();
        flash()->message('Category created!');

        return redirect()->route('backend.categories.index');
    }

    public function show($category_id)
    {
        $category = Category::query()->findOrFail($category_id);

        $data = [
            'title' => $category->title,
            'posts' => DB::table('posts')->where('category_id', $category_id)->get(),
        ];

        return view('backend.categories.show', $data);
    }

    public function edit($category_id)
    {
        $category = Category::query()->findOrFail($category_id);

        $data = [
            'categories' => Category::query()->all(),
            'category' => $category,
            'title' => $category->id . ': Edit Category',
        ];

        return view('backend.categories.edit', $data);
    }

    public function destroy($category_id)
    {
        $category = Category::query()->findOrFail($category_id);
        $category->delete();

        flash()->message('Category deleted!');

        return redirect('backend/posts');
    }

    public function update(Request $request, $category_id)
    {
        $category = Category::query()->findOrNew($category_id);

        $category->title = $request->input('title');
        $category->resluggify();
        $category->update();

        flash()->message('Category updated!');

        return redirect()->route('backend.categories.index');
    }
}
