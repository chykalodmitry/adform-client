<?php

namespace Audiens\AdForm\Entity;

use DateTime;

class DateParser
{
    public static function parse($date)
    {
        if ($date instanceof DateTime) {
            return $date;
        }

        if (\is_numeric($date)) {
            $dateTime = new DateTime();
            $dateTime->setTimestamp((int)$date);

            return $dateTime;
        }

        $format = 'Y-m-d\TH:i:sP'; // ISO 8601
        if (\preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $date .= 'T00:00:00+00:00';
        } elseif (\preg_match('/^(\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2})(\.\d{1,3})?Z$/', $date, $matches)) {
            $date = $matches[1].'+00:00';
        }

        return DateTime::createFromFormat($format, $date);
    }
}
