<?php

namespace App\Helpers {

    if (!function_exists('get_human_readable_duration')) {
        function get_human_readable_duration($total_time)
        {
            $seconds = str_pad($total_time % 60, 2, '0', STR_PAD_LEFT);
            $minutes = str_pad((floor($total_time / 60)) % 60, 2, '0', STR_PAD_LEFT);
            $hours = floor($total_time / 3600);

            $hoursString = ($hours == 0) ? '' : $hours . ':';
            $minutesString = ($minutes == 0) ? '' : $minutes . ':';
            $secondsString = $seconds;
            return $hoursString . $minutesString . $secondsString;
        }
    }
}