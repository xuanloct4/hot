<?php

namespace Src\Utils;

use Src\Definition\DateTime;

class DateTimeUtils
{
    public static function convertStringToDateTime($str, $format = null, DateTimeZone $timezone = null)
    {
        if ($format == null) {
            $dtFormat = DateTime::StandardFormat;
        } else {
            $dtFormat = $format;
        }
        return \DateTime::createFromFormat($dtFormat, $str, $timezone);
    }

    public static function convertDateTimeToString(\DateTime $dateTime, $format = null, DateTimeZone $timezone = null)
    {
        if ($format == null) {
            $dtFormat = DateTime::StandardFormat;
        } else {
            $dtFormat = $format;
        }

        if ($timezone != null) {
            $dateTime->setTimezone();
        }

        return $dateTime->format($dtFormat);
    }
}