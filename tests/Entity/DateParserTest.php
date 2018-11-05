<?php

namespace Audiens\AdForm\Tests\Entity;

use Audiens\AdForm\Entity\DateParser;
use DateTime;
use PHPUnit\Framework\TestCase;

class DateParserTest extends TestCase
{
    /**
     * @dataProvider parseDataProvider()
     *
     * @param        $raw
     * @param string $expected
     * @param string $format
     */
    public function test_parseWillProperlyManageAllKnownCases($raw, string $expected, string $format): void
    {
        $dateTime = DateParser::parse($raw);

        TestCase::assertEquals($expected, $dateTime->format($format));
    }

    public function parseDataProvider(): array
    {
        $dateTime = new DateTime('+7 days');
        $format = 'Y-m-d H:i:s';
        $expected = $dateTime->format($format);

        $YmdExpected = clone $dateTime;
        $YmdExpected->setTime(0, 0, 0);

        return [
            [$dateTime->getTimestamp(), $expected, $format],
            [''.$dateTime->getTimestamp(), $expected, $format],
            [$dateTime->format('Y-m-d'), $YmdExpected->format($format), $format],
            [$dateTime->format('Y-m-d\TH:i:s\Z'), $expected, $format],
            [$dateTime->format('Y-m-d\TH:i:s.098\Z'), $expected, $format],
        ];
    }
}
