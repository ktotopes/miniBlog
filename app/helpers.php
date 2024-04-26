<?php

use Carbon\Carbon;

if (! function_exists('formattedStorageString')) {
    function formattedStorageString(): string
    {
        $date = Carbon::now();

        if ($date->toArray()['month'] < 10) {
            $formatedString = 'public/' . $date->toArray()['year'] . '/' . '0' . $date->toArray()['month'] . '/' . $date->toArray()['day'];
        } else {
            $formatedString = 'public/' . $date->toArray()['year'] . '/' . $date->toArray()['month'] . '/' . $date->toArray()['day'];
        }

        return $formatedString;
    }
}



