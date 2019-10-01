<?php

namespace Src\Utils;


use Src\Definition\Comparison;

class StringUtils
{

    public static function compareVersion($v1, $v2) {
        if ($v1 == null && $v2 == null) {
            return Comparison::equal;
        } else if (($v1 != null && $v2 == null) || ($v1 == null && $v2 != null)) {
            return Comparison::undefine;
        } else {
            $v1Comp = explode(".", $v1);
            $v2Comp = explode(".", $v2);

            $v1Size = sizeof($v1Comp);
            $v2Size = sizeof($v2Comp);
            $max = max($v1Size,$v2Size);
            $min = min($v1Size,$v2Size);

            for ($i = 0; $i < $min; $i++) {
                if ($v1Comp[$i] < $v2Comp[$i]) {
                    return Comparison::ascending;
                } else if ($v1Comp[$i] > $v2Comp[$i]) {
                    return Comparison::descending;
                }
            }

            if ($v1Size > $v2Size) {
                for ($i = $v2Size; $i < $v1Size; $i++) {
                    if ($v1Comp[$i] > 0) {
                        return Comparison::descending;
                    }
                }
            } else {
                if ($v1Size < $v2Size) {
                    for ($i = $v1Size; $i < $v2Size; $i++) {
                        if ($v2Comp[$i] > 0) {
                            return Comparison::ascending;
                        }
                    }
                }
            }

            return Comparison::equal;
        }
    }

    public static function compareScope($s1, $s2) {
        if ($s1 == null && $s2 == null) {
            return Comparison::equal;
        } else if (($s1 != null && $s2 == null) || ($s1 == null && $s2 != null)) {
            return Comparison::undefine;
        } else {
            $s1Comp = explode("," , $s1);
            $s2Comp = explode("," , $s2);

            $s1Size = sizeof($s1Comp);
            $s2Size = sizeof($s2Comp);
            $max = max($s1Size,$s2Size);
            $min = min($s1Size,$s2Size);

            $isAscending = false;
            $isDescending = false;
            if ($s1Size > $s2Size) {
                for ($i = 0; $i < $min; $i++) {
                    if ($s1Comp[$i] < $s2Comp[$i]) {
                        $isAscending = true;
                    } else if ($s1Comp[$i] > $s2Comp[$i]) {
                        $isDescending = true;
                    }
                }

                for ($i = $s2Size; $i < $s1Size; $i++) {
                    if ($s1Comp[$i] > 0) {
                        $isDescending = true;
                    }
                }
            } else {
                for ($i = 0; $i < $min; $i++) {
                    if ($s1Comp[$i] < $s2Comp[$i]) {
                        $isAscending = true;
                    } else if ($s1Comp[$i] > $s2Comp[$i]) {
                        $isDescending = true;
                    }
                }

                if ($s1Size < $s2Size) {
                    for ($i = $s1Size; $i < $s2Size; $i++) {
                        if ($s2Comp[$i] > 0) {
                            $isAscending = true;
                        }
                    }
                }
            }

            if (!$isAscending && !$isDescending){
                return Comparison::equal;
            } else if ($isAscending && !$isDescending){
                return Comparison::ascending;
            } else if (!$isAscending && $isDescending){
                return Comparison::descending;
            } else {
                return Comparison::undefine;
            }
        }
    }
}