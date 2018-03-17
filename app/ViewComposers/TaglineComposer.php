<?php
declare(strict_types=1);

namespace App\ViewComposers;

use App\Models\Tag;
use Illuminate\Contracts\View\View;
use App\Support\Queries\CountTags;

/**
 * Class TaglineComposer
 *
 * @package App\ViewComposers
 */
class TaglineComposer
{
    /**
     * @var Tag
     */
    protected $tag;

    /**
     * TaglineComposer constructor.
     *
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
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
