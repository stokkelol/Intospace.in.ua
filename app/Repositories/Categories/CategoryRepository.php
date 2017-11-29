<?php

namespace App\Repositories\Categories;

use App\Models\Category;

class CategoryRepository
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
