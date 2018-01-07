<?php
declare(strict_types=1);

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\Tags\TagRepository;
use App\Support\Queries\CountTags;

/**
 * Class TaglineComposer
 *
 * @package App\ViewComposers
 */
class TaglineComposer
{
    /**
     * @var TagRepository
     */
    protected $tag;

    /**
     * TaglineComposer constructor.
     *
     * @param TagRepository $tag
     */
    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        $tags = (new CountTags)->get(10);

        $view->with('tags', $tags);
    }
}
