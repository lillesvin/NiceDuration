<?php
/**
 * @author      Anders K. Madsen <lillesvin@gmail.com>
 */
namespace NiceDuration;

class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $this->setExpectedException('\NiceDuration\Exception');
        throw new Exception('Test exception');
    }
}

