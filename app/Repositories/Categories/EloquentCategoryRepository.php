<?php

namespace App\Repositories\Categories;

use App\Models\Category;
use App\Repositories\Categories\CategoryRepository;

class EloquentCategoryRepository implements CategoryRepository
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAllCategories()
    {
        $categories = $this->category->all();

        return $categories;
    }
}
