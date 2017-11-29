<?php
declare(strict_types=1);

namespace App\Repositories\Categories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CategoryRepository
 *
 * @package App\Repositories\Categories
 */
class CategoryRepository
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories(): Collection
    {
        return $this->category->all();
    }
}
