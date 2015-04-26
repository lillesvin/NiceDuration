<?php
/**
 * @author      Anders K. Madsen <lillesvin@gmail.com>
 * @coversDefaultClass   \NiceDuration\NiceDuration
 */
class NiceDurationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers  ::__construct
     * @covers  ::validateFloat
     * @covers  ::extractParts
     */
    public function testConstruct()
    {
        $input = 594.11;
        $this->assertInstanceOf('\NiceDuration\NiceDuration',
            new \NiceDuration\NiceDuration($input));
    }

    /**
     * @covers  ::__construct
     * @covers  ::validateFloat
     */
    public function testConstructInvalidDuration()
    {
        $input = "41.4sd";
        $this->setExpectedException('\NiceDuration\Exception');
        $nd = new \NiceDuration\NiceDuration($input);
    }

    /**
     * @covers  ::setFractionCutoff
     * @covers  ::getFractionCutoff
     * @covers  ::validateFloat
     */
    public function testFractionCutoff()
    {
        $input  = 3600;
        $nd = new \NiceDuration\NiceDuration(1);
        $nd->setFractionCutoff($input);
        $this->assertEquals($input, $nd->getFractionCutoff());
    }

    /**
     * @covers  ::setFractionCutoff
     * @covers  ::getFractionCutoff
     * @covers  ::validateFloat
     */
    public function testInvalidFractionCutoff()
    {
        $input = "4m.af";
        $nd = new \NiceDuration\NiceDuration(1);
        $nd->setFractionCutoff($input);
        $this->assertNull($nd->getFractionCutoff());
    }

    /**
     * @covers  ::getFractionCutoff
     */
    public function testDefaultFractionCutoff()
    {
        $nd = new \NiceDuration\NiceDuration(1);
        $this->assertEquals(43200, $nd->getFractionCutoff());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertSubsecond()
    {
        // 0.1234 seconds
        $input  = 0.1234;
        $output = "0.123";

        $nd = new \NiceDuration\NiceDuration($input);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertSubsecondWithFraction()
    {
        // 0.1234 seconds
        $input  = 0.1234;
        $output = "0.123";

        $nd = new \NiceDuration\NiceDuration($input);
        $nd->setFractionCutoff(null);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertSubsecondNoFraction()
    {
        // 0.1234 seconds
        $input  = 0.1234;
        $output = "0";

        $nd = new \NiceDuration\NiceDuration($input);
        $nd->setFractionCutoff(0);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertSecond()
    {
        // 3.1415 seconds
        $input  = 3.1415;
        $output = "3.141";

        $nd = new \NiceDuration\NiceDuration($input);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertSecondWithFraction()
    {
        // 3.1415 seconds
        $input  = 3.1415;
        $output = "3.141";

        $nd = new \NiceDuration\NiceDuration($input);
        $nd->setFractionCutoff(null);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertSecondNoFraction()
    {
        // 3.1415 seconds
        $input  = 3.1415;
        $output = "3";

        $nd = new \NiceDuration\NiceDuration($input);
        $nd->setFractionCutoff(0);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertMinute()
    {
        // 22 minutes and 44.4 seconds
        $input  = (60 * 22) + 44.4;
        $output = "22:44.400";

        $nd = new \NiceDuration\NiceDuration($input);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertMinuteWithFraction()
    {
        // 22 minutes and 44.4 seconds
        $input  = (60 * 22) + 44.4;
        $output = "22:44.400";

        $nd = new \NiceDuration\NiceDuration($input);
        $nd->setFractionCutoff(null);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertMinuteNoFraction()
    {
        // 22 minutes and 44.4 seconds
        $input  = (60 * 22) + 44.4;
        $output = "22:44";

        $nd = new \NiceDuration\NiceDuration($input);
        $nd->setFractionCutoff(0);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertHour()
    {
        // 14 hours, 21 minutes and 1.121 seconds
        $input  = (3600 * 14) + (60 * 21) + 1.121;
        $output = "14:21:01";

        $nd = new \NiceDuration\NiceDuration($input);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertHourWithFraction()
    {
        // 14 hours, 21 minutes and 1.121 seconds
        $input  = (3600 * 14) + (60 * 21) + 1.121;
        $output = "14:21:01.121";

        $nd = new \NiceDuration\NiceDuration($input);
        $nd->setFractionCutoff(null);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertHourNoFraction()
    {
        // 14 hours, 21 minutes and 1.121 seconds
        $input  = (3600 * 14) + (60 * 21) + 1.121;
        $output = "14:21:01";

        $nd = new \NiceDuration\NiceDuration($input);
        $nd->setFractionCutoff(0);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertDay()
    {
        // 2 days, 13 hours, 51 minutes and 24.919 seconds
        $input  = (86400 * 2) + (3600 * 13) + (60 * 51) + 24.919;
        $output = "2d 13:51:24";

        $nd = new \NiceDuration\NiceDuration($input);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertDayWithFraction()
    {
        // 2 days, 13 hours, 51 minutes and 24.919 seconds
        $input  = (86400 * 2) + (3600 * 13) + (60 * 51) + 24.919;
        $output = "2d 13:51:24.919";

        $nd = new \NiceDuration\NiceDuration($input);
        $nd->setFractionCutoff(null);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertDayNoFraction()
    {
        // 2 days, 13 hours, 51 minutes and 24.919 seconds
        $input  = (86400 * 2) + (3600 * 13) + (60 * 51) + 24.919;
        $output = "2d 13:51:24";

        $nd = new \NiceDuration\NiceDuration($input);
        $nd->setFractionCutoff(0);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertYear()
    {
        // 4 years, 84 days, 3 hours, 8 minutes and 1.13 seconds
        $input  = (86400 * 365 * 4) + (86400 * 84) + (3600 * 3) + (60 * 8) + 1.13;
        $output = "4y 84d 03:08:01";

        $nd = new \NiceDuration\NiceDuration($input);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertYearWithFraction()
    {
        // 4 years, 84 days, 3 hours, 8 minutes and 1.13 seconds
        $input  = (86400 * 365 * 4) + (86400 * 84) + (3600 * 3) + (60 * 8) + 1.13;
        $output = "4y 84d 03:08:01.130";

        $nd = new \NiceDuration\NiceDuration($input);
        $nd->setFractionCutoff(null);
        $this->assertEquals($output, $nd->format());
    }

    /**
     * @covers  ::format
     * @covers  ::formatTime
     */
    public function testConvertYearNoFraction()
    {
        // 4 years, 84 days, 3 hours, 8 minutes and 1.13 seconds
        $input  = (86400 * 365 * 4) + (86400 * 84) + (3600 * 3) + (60 * 8) + 1.13;
        $output = "4y 84d 03:08:01";

        $nd = new \NiceDuration\NiceDuration($input);
        $nd->setFractionCutoff(0);
        $this->assertEquals($output, $nd->format());
    }
}
