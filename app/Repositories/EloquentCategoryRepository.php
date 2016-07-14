<?php

namespace App\Repositories;

use App\Category;

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
