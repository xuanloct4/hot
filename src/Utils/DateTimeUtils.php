<?php

namespace Src\Utils;

use Src\Definition\DateTime;

class DateTimeUtils
{
    public static function convertStringToDateTime($str, $format = null, \DateTimeZone $timezone = null)
    {
        if ($format == null) {
            $dtFormat = DateTime::StandardFormat;
        } else {
            $dtFormat = $format;
        }
        return \DateTime::createFromFormat($dtFormat, $str, $timezone);
    }

    public static function convertDateTimeToString(\DateTime $dateTime, $format = null, \DateTimeZone $timezone = null)
    {
        if ($format == null) {
            $dtFormat = DateTime::StandardFormat;
        } else {
            $dtFormat = $format;
        }

        if ($timezone != null) {
            $dateTime->setTimezone($timezone);
        }

        return $dateTime->format($dtFormat);
    }

    public static function convertStringToDateTimeDB($str, \DateTimeZone $timezone = null)
    {
        return self::convertStringToDateTime($str, DateTime::DBFormat, $timezone);
    }

    public static function convertDateTimeToStringDB(\DateTime $dateTime, $format = null, \DateTimeZone $timezone = null)
    {
        return self::convertStringToDateTime($dateTime, DateTime::DBFormat, $timezone);
    }

    public static function getCurrentTimeString($format = null, \DateTimeZone $timezone = null) {
        $date = new \DateTime('now', $timezone);
        return self::convertDateTimeToString($date, $format, $timezone);
    }

    public static function getCurrentTime($format = null, \DateTimeZone $timezone = null) {
        $str = self::getCurrentTimeString($format, $timezone);
        return self::convertStringToDateTime($str, $format, $timezone);
    }
}
