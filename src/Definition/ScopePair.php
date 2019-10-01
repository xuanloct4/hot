<?php

namespace Src\Definition;


class ScopePair
{
    public $level;
    public $order;
    private $actions;
    private $description;

    /**
     * ScopePair constructor.
     * @param $level
     * @param $order
     */
    public function __construct($level, $order)
    {
        $this->level = $level;
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function toArray($maxSize)
    {
        $scope = array();
        for ($i = 0; $i < $maxSize; $i++) {
            if ($this->order == $i) {
                $scope[$i] = $this->level;
            } else {
                $scope[$i] = 0;
            }
        }

        return $scope;
    }

    public static function updateScopeArray($array, $scope)
    {
        if ($scope->order < sizeof($array)) {
            $array[$scope->order] = $scope->level;
        } else {
            for ($i = sizeof($array); $i <= $scope->order; $i++) {
                if ($scope->order == $i) {
                    $array[$i] = $scope->level;
                } else {
                    $array[$i] = 0;
                }
            }
        }

        return $array;
    }

    public static function scopeArrayToString($array)
    {
        $str = "";
        for ($i = 0; $i < sizeof($array); $i++) {
            $str = "{$str}{$array[$i]}";
            if ($i < sizeof($array)-1) {
                $str = "{$str},";
            }
        }

        return $str;
    }
}