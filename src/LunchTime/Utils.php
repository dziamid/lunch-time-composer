<?php
namespace LunchTime;

class Utils
{
    /**
     * The missing array_search with closure support function
     *
     * @static
     * @param $array
     * @param $callback
     * @return bool
     */
    public static function array_first(array $array, $callback)
    {
        foreach ($array as $item) {
            if ($callback($item)) {
                return $item;
            }
        }
        return false;
    }

    public static function array_filter_unique(array $array, $callback)
    {
        $items = array();

        foreach ($array as $item) {
            //value that defines uniqueness
            $value = $callback($item);
            if (!isset($items[$value])) {
                $items[$value] = $item;
            }
        }

        return array_values($items);
    }
}