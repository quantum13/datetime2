<?php

use Quantum13\DateTime2;

class DateTime2Test extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $date = new DateTime2('2014-01-01');
        $this->assertInstanceOf('\DateTime', $date);

        $this->assertEquals(1, $date->getDay());
        $this->assertEquals(1, $date->getMonth());

        $date->setTime(1, 2, 3);
        $date2 = new DateTime2($date);
        $this->assertEquals($date, $date2);

        //static
        $date = DateTime2::create('2014-01-01');
        $this->assertInstanceOf('\DateTime', $date);

        $this->assertEquals(1, $date->getDay());
        $this->assertEquals(1, $date->getMonth());

        $date->setTime(1, 2, 3);
        $date2 = DateTime2::create($date);
        $this->assertEquals($date, $date2);
    }

    public function testAddDay()
    {
        $date = new DateTime2('2014-01-01');
        $date->addDay();
        $this->assertEquals(2, $date->getDay());
        $this->assertEquals(1, $date->getMonth());

        $returned = $date->addDay(-2);
        $this->assertEquals(31, $date->getDay());
        $this->assertEquals(12, $date->getMonth());

        $this->assertTrue($returned === $date);
    }

    public function testSetDay()
    {
        $date = new DateTime2('2014-01-01');
        $returned = $date->setDay(4);
        $this->assertEquals(4, $date->getDay());
        $this->assertEquals(1, $date->getMonth());

        $this->assertTrue($returned === $date);
    }

    public function testAddMonth()
    {
        $date = new DateTime2('2014-01-01');
        $date->addMonth();
        $this->assertEquals(1, $date->getDay());
        $this->assertEquals(2, $date->getMonth());

        $returned = $date->addMonth(-2);
        $this->assertEquals(1, $date->getDay());
        $this->assertEquals(12, $date->getMonth());

        $this->assertTrue($returned === $date);
    }

    public function testSetToLastDayOfMonth()
    {
        $date = new DateTime2('2014-01-01');
        $date->setToLastDayOfMonth();
        $this->assertEquals(31, $date->getDay());

        $date = new DateTime2('2014-02-01');
        $date->setToLastDayOfMonth();
        $this->assertEquals(28, $date->getDay());
    }

    public function testIsLastDayOfMonth()
    {
        $date = new DateTime2('2014-01-30');
        $this->assertFalse($date->isLastDayOfMonth());

        $date->addDay();
        $this->assertTrue($date->isLastDayOfMonth());
    }

    public function testDaysInMonth()
    {
        $date = new DateTime2('2014-01-30');
        $this->assertEquals(31, $date->daysInMonth());

        $date->addDay(2);
        $this->assertEquals(28, $date->daysInMonth());
    }

    public function testClearTime()
    {
        $date = new DateTime2('2014-01-30 01:02:03');
        $this->assertEquals('01:02:03', $date->format("H:i:s"));
        $returned = $date->clearTime();
        $this->assertEquals('00:00:00', $date->format("H:i:s"));

        $this->assertTrue($returned === $date);
    }

    public function testConvertingToStringRus()
    {
        $date = new DateTime2('2014-01-30 01:02:03');
        $this->assertEquals('30.01.2014', $date->toStringRus());
        $this->assertEquals('30.01.2014 01:02:03', $date->toStringRus(true));
    }

    public function testConvertingToStringSql()
    {
        $date = new DateTime2('2014-01-30 01:02:03');
        $this->assertEquals('2014-01-30', $date->toStringSql());
        $this->assertEquals('2014-01-30 01:02:03', $date->toStringSql(true));
    }

    public function testReplaceNow()
    {
        DateTime2::$manualNow = '2015-05-17 12:15:17';

        $date = DateTime2::create();
        $this->assertEquals('17.05.2015 12:15:17', $date->toStringRus(true));

        $date = new DateTime2();
        $this->assertEquals('17.05.2015 12:15:17', $date->toStringRus(true));

        $date = DateTime2::create('');
        $this->assertEquals('17.05.2015 12:15:17', $date->toStringRus(true));


        DateTime2::$manualNow = null;

        $date = DateTime2::create();
        $this->assertNotEquals('17.05.2015 12:15:17', $date->toStringRus(true));

        $date = new DateTime2();
        $this->assertNotEquals('17.05.2015 12:15:17', $date->toStringRus(true));

        $date = DateTime2::create('');
        $this->assertNotEquals('17.05.2015 12:15:17', $date->toStringRus(true));

    }

}