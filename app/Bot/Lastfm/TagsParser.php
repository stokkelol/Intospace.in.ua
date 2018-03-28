<?php
declare(strict_types=1);

namespace App\Bot\Lastfm;

use App\Models\Band;
use App\Models\Tag;

/**
 * Class TagsParser
 *
 * @package App\Bot\Lastfm
 */
class TagsParser
{
    /**
     * @var Lastfm
     */
    private $api;

    /**
     * SimilarityParser constructor.
     *
     * @param Lastfm $api
     */
    public function __construct(Lastfm $api)
    {
        $this->api = $api;
    }

    public function handle()
    {
        /** @var Tag[] $tags */
        $tagsModels = Tag::query()->get();

//        Band::query()->whereDoesntHave('tags')->chunk(1000, function ($bands) use ($tagsModels) {
//            /** @var Band $band */
//            foreach ($bands as $band) {
//                $result = $this->api->getArtistTopTags($band->title)->get();
//
//                if (isset($result['toptags'])) {
//                    $tags = \array_filter($result['toptags']['tag'], function ($tag) {
//                        return $tag['count'] > 10;
//                    });
//
//                    if (!empty($tags)) {
//                        $models = [];
//
//                        foreach ($tags as $tag) {
//                            $r = $tagsModels->where('tag', 'like', $tag['name'])->first();
//
//                            if ($r !== null) {
//                                $models[$r['id']] = [
//                                    'value' => $tag['count']
//                                ];
//                            }
//                        }
//                    }
//
//                    if (!empty($models)) {
//                        $band->tags()->sync($models);
//                    }
//                }
//            }
//        });

        Band::query()->chunk(1000, function ($bands) use ($tagsModels) {
            /** @var Band $band */
            foreach ($bands as $band) {
                $result = $this->api->getArtistTopTags($band->title)->get();

                if (isset($result['toptags'])) {
                    $tags = \array_filter($result['toptags']['tag'], function ($tag) {
                        return $tag['count'] > 10;
                    });

                    if (!empty($tags)) {
                        $models = [];

                        foreach ($tags as $tag) {
                            $name = \strtolower(\str_replace('-', '', $tag['name']));
                            $r = $tagsModels->where('tag', 'like', $name)->first();

                            if ($r !== null) {
                                $models[$r['id']] = [
                                    'value' => $tag['count']
                                ];
                            }
                        }
                    }

                    if (!empty($models)) {
                        $band->tags()->syncWithoutDetaching($models);
                    }
                }
            }
        });
    }
}