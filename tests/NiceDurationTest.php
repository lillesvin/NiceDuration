<?php
/**
 * @author      Anders K. Madsen <lillesvin@gmail.com>
 */
namespace NiceDuration;

class NiceDurationTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $input = 594.11;
        $this->assertInstanceOf('\NiceDuration\NiceDuration',
            new NiceDuration($input)
        );
    }

    public function testConstructInvalidDuration()
    {
        $input = "41.4sd";
        $this->setExpectedException('\NiceDuration\Exception');
        $nd = new NiceDuration($input);
    }

    public function testFractionCutoff()
    {
        $input  = 3600;
        $nd = new NiceDuration(1);
        $nd->setFractionCutoff($input);
        $this->assertEquals($input, $nd->getFractionCutoff());
    }

    public function testInvalidFractionCutoff()
    {
        $input = "4m.af";
        $nd = new NiceDuration(1);
        $nd->setFractionCutoff($input);
        $this->assertNull($nd->getFractionCutoff());
    }

    public function testDefaultFractionCutoff()
    {
        $nd = new NiceDuration(1);
        $this->assertEquals(43200, $nd->getFractionCutoff());
    }

    public function testConvertSubsecond()
    {
        // 0.1234 seconds
        $input  = 0.1234;
        $output = "0.123";

        $nd = new NiceDuration($input);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertSubsecondWithFraction()
    {
        // 0.1234 seconds
        $input  = 0.1234;
        $output = "0.123";

        $nd = new NiceDuration($input);
        $nd->setFractionCutoff(null);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertSubsecondNoFraction()
    {
        // 0.1234 seconds
        $input  = 0.1234;
        $output = "0";

        $nd = new NiceDuration($input);
        $nd->setFractionCutoff(0);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertSecond()
    {
        // 3.1415 seconds
        $input  = 3.1415;
        $output = "3.141";

        $nd = new NiceDuration($input);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertSecondWithFraction()
    {
        // 3.1415 seconds
        $input  = 3.1415;
        $output = "3.141";

        $nd = new NiceDuration($input);
        $nd->setFractionCutoff(null);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertSecondNoFraction()
    {
        // 3.1415 seconds
        $input  = 3.1415;
        $output = "3";

        $nd = new NiceDuration($input);
        $nd->setFractionCutoff(0);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertMinute()
    {
        // 22 minutes and 44.4 seconds
        $input  = (60 * 22) + 44.4;
        $output = "22:44.400";

        $nd = new NiceDuration($input);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertMinuteWithFraction()
    {
        // 22 minutes and 44.4 seconds
        $input  = (60 * 22) + 44.4;
        $output = "22:44.400";

        $nd = new NiceDuration($input);
        $nd->setFractionCutoff(null);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertMinuteNoFraction()
    {
        // 22 minutes and 44.4 seconds
        $input  = (60 * 22) + 44.4;
        $output = "22:44";

        $nd = new NiceDuration($input);
        $nd->setFractionCutoff(0);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertHour()
    {
        // 14 hours, 21 minutes and 1.121 seconds
        $input  = (3600 * 14) + (60 * 21) + 1.121;
        $output = "14:21:01";

        $nd = new NiceDuration($input);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertHourWithFraction()
    {
        // 14 hours, 21 minutes and 1.121 seconds
        $input  = (3600 * 14) + (60 * 21) + 1.121;
        $output = "14:21:01.121";

        $nd = new NiceDuration($input);
        $nd->setFractionCutoff(null);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertHourNoFraction()
    {
        // 14 hours, 21 minutes and 1.121 seconds
        $input  = (3600 * 14) + (60 * 21) + 1.121;
        $output = "14:21:01";

        $nd = new NiceDuration($input);
        $nd->setFractionCutoff(0);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertDay()
    {
        // 2 days, 13 hours, 51 minutes and 24.919 seconds
        $input  = (86400 * 2) + (3600 * 13) + (60 * 51) + 24.919;
        $output = "2d 13:51:24";

        $nd = new NiceDuration($input);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertDayWithFraction()
    {
        // 2 days, 13 hours, 51 minutes and 24.919 seconds
        $input  = (86400 * 2) + (3600 * 13) + (60 * 51) + 24.919;
        $output = "2d 13:51:24.919";

        $nd = new NiceDuration($input);
        $nd->setFractionCutoff(null);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertDayNoFraction()
    {
        // 2 days, 13 hours, 51 minutes and 24.919 seconds
        $input  = (86400 * 2) + (3600 * 13) + (60 * 51) + 24.919;
        $output = "2d 13:51:24";

        $nd = new NiceDuration($input);
        $nd->setFractionCutoff(0);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertYear()
    {
        // 4 years, 84 days, 3 hours, 8 minutes and 1.13 seconds
        $input  = (86400 * 365 * 4) + (86400 * 84) + (3600 * 3) + (60 * 8) + 1.13;
        $output = "4y 84d 03:08:01";

        $nd = new NiceDuration($input);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertYearWithFraction()
    {
        // 4 years, 84 days, 3 hours, 8 minutes and 1.13 seconds
        $input  = (86400 * 365 * 4) + (86400 * 84) + (3600 * 3) + (60 * 8) + 1.13;
        $output = "4y 84d 03:08:01.130";

        $nd = new NiceDuration($input);
        $nd->setFractionCutoff(null);
        $this->assertEquals($output, $nd->format());
    }

    public function testConvertYearNoFraction()
    {
        // 4 years, 84 days, 3 hours, 8 minutes and 1.13 seconds
        $input  = (86400 * 365 * 4) + (86400 * 84) + (3600 * 3) + (60 * 8) + 1.13;
        $output = "4y 84d 03:08:01";

        $nd = new NiceDuration($input);
        $nd->setFractionCutoff(0);
        $this->assertEquals($output, $nd->format());
    }
}
