<?php

namespace App\Services;

use Carbon\Carbon;

class DateTimeService
{

    public static function getTimeNow(): string
    {
        $today = new Carbon();
        return Carbon::parse($today->toDateTimeString())->format('Y-M-d');
    }

    public static function getYesterday(): string
    {
        $today = new Carbon();
        $today->sub(1, "day");
        return Carbon::parse($today->toDateTimeString())->format('Y-M-d');
    }

    public function getSub12Hours(): string
    {
        $yesterday = new Carbon();
        $yesterday->sub(12, "hours");
        $yesterday->toDateTimeString();
        return Carbon::parse($yesterday)->format('H');
    }
}