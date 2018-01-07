<?php
declare(strict_types=1);

namespace App\Transformers;

/**
 * Class Transformer
 *
 * @package App\Transformers
 */
abstract class Transformer
{
    /**
     * @param iterable $items
     * @return array
     */
    public function transformCollection(iterable $items)
    {
        $result = [];

        foreach ($items as $item) {
            $result[] = $this->transform($item);
        }

        return $result;
    }

    /**
     * @param $item
     * @return array
     */
    abstract public function transform($item): array;
}