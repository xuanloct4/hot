<?php

namespace Src\Utils;

use Src\Definition\Comparison;

class ArrayUtils
{
    public static function convertToObject($array)
    {
        $object = new stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = convertToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }

    public static function sort(Array $arr, Array $columns)
    {
        $sortedArray = $arr;

        for ($i = 0; $i < sizeof($columns); $i++) {
            $column = $columns[$i];
            $columnName = $column->column;
            $columnAscending = $column->isAscending;
            $key = array();
            foreach ($arr as $item) {
                array_push($key, $item->$columnName);
            }
            if ($columnAscending == Comparison::ascending) {
                array_multisort($key, SORT_ASC, $sortedArray);
            } else {
                array_multisort($key, SORT_DESC, $sortedArray);
            }
        }

        return $sortedArray;
    }

}