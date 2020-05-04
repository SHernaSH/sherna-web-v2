<?php


namespace App\Http\Collections;

use Illuminate\Database\Eloquent\Collection;

/**
 * Collection class for eloquent models with composite primary keys
 *
 * Class CompositeCollection
 * @package App\Http\Collections
 */
class CompositeCollection extends Collection {
    /**
     * Diff the collection with the given items.
     *
     * @param \ArrayAccess|array $items
     * @return CompositeCollection
     */
    public function diff($items)
    {
        $diff = new static;

        $dictionary = $this->getDictionary($items);

        foreach ($this->items as $item) {
            $keys = $item->getKey();
            if(!is_array($keys)) {
                if (! isset($dictionary[$keys])) {
                    $diff->add($item);
                }
            } else {
                foreach ($keys as $key) {
                    if (!isset($dictionary[$key])) {
                        $diff->add($item);
                    }
                }
            }
        }

        return $diff;
    }

    /**
     * Get a dictionary keyed by primary keys.
     *
     * @param  \ArrayAccess|array|null  $items
     * @return array
     */
    public function getDictionary($items = null)
    {
        $items = is_null($items) ? $this->items : $items;

        $dictionary = [];

        foreach ($items as $value) {
            $keys = $value->getKey();
            if(!is_array($keys)) {
                $dictionary[$keys] = $value;
            } else {
                foreach ($keys as $key)
                    $dictionary[$key] = $value;
            }
        }

        return $dictionary;
    }
}
