<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;

class Timezone {
    public const WIB = 'Asia/Jakarta';
    public const WITA = 'Asia/Makassar';
    public const WIT = 'Asia/Jayapura';

    public static function convert($date, $format = 'd F Y H:i:s', $timezone = 'Asia/Jakarta')
    {
        if ($date == null) {
            return '-';
        }

        return Carbon::parse($date)->setTimezone($timezone)->translatedFormat($format);
    }
    public static function display($date, $includeDiff = false, $format = 'd F Y H:i:s', $timezone = 'Asia/Jakarta')
    {
        if ($date == null) {
            return '-';
        }

        $result = Carbon::parse($date)->setTimezone($timezone)->translatedFormat($format);

        // check if format includes time
        if (str_contains($format, 'H') || str_contains($format, 'h')) {
            if ($timezone == 'Asia/Jakarta') {
                $result .= ' WIB';
            } else if ($timezone == 'Asia/Makassar') {
                $result .= ' WITA';
            } else if ($timezone == 'Asia/Jayapura') {
                $result .= ' WIT';
            }
        }

        if ($includeDiff) {
            $result .= ' (' . self::diffForHumans($date, $timezone) . ')';
        }

        return $result;
    }

    public static function diffInHours($date, $timezone = 'Asia/Jakarta')
    {
        // only diff hour
        return Carbon::parse($date)->setTimezone($timezone)->diffInHours();
    }

    public static function diffForHumans($date, $timezone = 'Asia/Jakarta')
    {
        if ($date == null) {
            return '-';
        }

        return Carbon::parse($date)->setTimezone($timezone)->diffForHumans();
    }

    public static function now($timezone = 'Asia/Jakarta')
    {
        return Carbon::now($timezone);
    }

    public static function toUTC($date, $fromFormat = 'Y-m-d H:i:s', $toFormat = 'Y-m-d H:i:s', $fromTimezone = 'Asia/Jakarta')
    {
        if ($date == null) {
            return null;
        }

        return Carbon::createFromFormat($fromFormat, $date, $fromTimezone)->setTimezone('UTC')->format($toFormat);
    }
}
