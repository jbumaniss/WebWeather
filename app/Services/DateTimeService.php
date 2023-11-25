<?php

namespace App\Services;

use Carbon\Carbon;

class DateTimeService
{

    public static function getTimeNow(): string
    {
        $today = new Carbon();
        return Carbon::now()->format('Y-m-d');
    }

    public static function getYesterday(): string
    {
        return Carbon::now()->subDay()->format('Y-m-d');
    }

    public function getSub12Hours(): string
    {
        return Carbon::now()->subHours(12)->toDateTimeString();
    }
}