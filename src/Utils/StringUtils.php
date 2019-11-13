<?php

namespace Src\Utils;


use Src\Definition\Comparison;

class StringUtils
{
    public static function getScopes($str) {
        $scopes = StringUtils::trimStringToArray("|", $str);
        for ($i = 0; $i < sizeof($scopes); $i++) {
            if (strcmp("",$scopes[$i]) == 0) {
                $scopes[$i] = "0,0,0,0";
            }
        }
        return $scopes;
    }

    public static function trimStringToArray($delimiter,$str) {
        $arr = explode($delimiter, $str);
        for ($i = 0; $i < sizeof($arr); $i++) {
            $arr[$i] = trim($arr[$i]);
        }
        return $arr;
    }

    public static function trimStringToArrayWithNonEmptyElement($delimiter,$str) {
        $separatedComponentsArray = explode($delimiter, $str);
        $nonEmptyElementsArray = array();
        for ($i = 0; $i < sizeof($separatedComponentsArray); $i++) {
            $trimmed = trim($separatedComponentsArray[$i]);
            if (strcmp("",$trimmed) != 0) {
                array_push($nonEmptyElementsArray, $trimmed);
            }
        }
        return $nonEmptyElementsArray;
    }

    public static function compareVersion($v1, $v2) {
        if ($v1 == null && $v2 == null) {
            return Comparison::equal;
        } else if (($v1 != null && $v2 == null) || ($v1 == null && $v2 != null)) {
            return Comparison::undefine;
        } else {
            $v1Comp = self::trimStringToArray(".", $v1);
            $v2Comp = self::trimStringToArray(".", $v2);

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
            $s1Comp = self::trimStringToArray("," , $s1);
            $s2Comp = self::trimStringToArray("," , $s2);

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

    public static function generateRandomString($length=12) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public static function compareStringIgnoreCase($str1, $str2) {
        if (strcmp($str1, $str2) == 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function compareString($str1, $str2) {
        if (strcasecmp($str1, $str2) == 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function arrayToString($separator,$arr) {
        $str = implode($separator, $arr);
        return $str;
    }

    public static function isNullOrEmpty($str) {
        if ($str == null || strcmp("", trim($str)) == 0) {
            return true;
        } else {
            return false;
        }
    }
}
