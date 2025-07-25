<?php

namespace App\Helpers;

class Greeting
{
    public static function sayHello()
    {
        // check if morning, afternoon or evening
        $hour = now();
        // convert timezone
        $hour = Timezone::convert($hour, 'H');
        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour >= 12 && $hour < 17) {
            $greeting = 'Selamat Siang';
        } else {
            $greeting = 'Selamat Malam';
        }

        return 'Halo, ' . $greeting . '.';
    }
}
