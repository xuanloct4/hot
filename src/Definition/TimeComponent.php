<?php

namespace Src\Definition;

use MyCLabs\Enum\Enum;

class TimeComponent extends Enum
{
    const second = "second";
    const minute = "minute";
    const hour = "hour";
    const day = "day";
    const daysOfWeek = "daysOfWeek";
    const month = "month";
    const year = "year";

}

class DaysOfWeek extends Enum
{
    const Monsday = "Monsday";
    const Tuesday = "Tuesday";
    const Wednesday = "Wednesday";
    const Thursday = "Thursday";
    const Friday = "Friday";
    const Saturday = "Saturday";
    const Sunday = "Sunday";
}
