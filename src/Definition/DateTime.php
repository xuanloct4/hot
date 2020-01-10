<?php

namespace Src\Definition;

use MyCLabs\Enum\Enum;

class DateTime extends Enum
{
    const DBFormat = "Y-m-d H:i:s";
    const StandardFormat = "Y-m-d H:i:s.u";
    const DateStandardFormat = "Y-m-d";
    const TimeStandardFormat = "H:i:s.u";


    const component = array(TimeComponent::second,
        TimeComponent::minute,
        TimeComponent::hour,
        TimeComponent::day,
        TimeComponent::daysOfWeek,
        TimeComponent::month,
        TimeComponent::year);

    const daysOfWeek = array(DaysOfWeek::Monsday,
        DaysOfWeek::Tuesday,
        DaysOfWeek::Wednesday,
        DaysOfWeek::Thursday,
        DaysOfWeek::Friday,
        DaysOfWeek::Thursday,
        DaysOfWeek::Sunday);

    const secondRange = array('MIN' => 0, 'MAX' => 59);

    const minuteRange = array('MIN' => 0, 'MAX' => 59);

    const hourRange = array('MIN' => 0, 'MAX' => 23);

    const dayRange = array('MIN' => 1, 'MAX' => 31);

    const monthRange = array('MIN' => 1, 'MAX' => 12);

    const yearRange = array('MIN' => 2019, 'MAX' => 2050);

    const TimeComponents = array(
        array('component' => TimeComponent::second, 'range' => DateTime::secondRange),
        array('component' => TimeComponent::minute, 'range' => DateTime::minuteRange),
        array('component' => TimeComponent::hour, 'range' => DateTime::hourRange),
        array('component' => TimeComponent::day, 'range' => DateTime::dayRange),
        array('component' => TimeComponent::daysOfWeek, 'range' => DateTime::daysOfWeek),
        array('component' => TimeComponent::month, 'range' => DateTime::monthRange),
        array('component' => TimeComponent::year, 'range' => DateTime::yearRange)
    );

}
