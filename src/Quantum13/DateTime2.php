<?php
namespace Quantum13;

class DateTime2 extends \DateTime
{
    public static $monthes_cyrillic = ['', 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'];

    public function __construct($time='now', \DateTimeZone $timezone=null)
    {
        if ($time instanceof DateTime2) {
            $time = $time->toStringSql(true);
        }

        try {
            $tempDate = new \DateTime($time);//Строка для того, чтобы при неправильной дате вывалиться в catch и создать объект
            parent::__construct($time, $timezone);
        } catch (\Exception $e) {
            parent::__construct('now', $timezone);
        }
    }

    /**
     * Добавить день к дате
     * @param int $count
     * @return $this
     */
    public function addDay($count=1)
    {
        $count = (int) $count;
        $this->modify("{$count} day");

        return $this;
    }

    public function getDay()
    {
        return (int) $this->format('d');
    }

    public function setDay($day)
    {
        $this->setDate($this->format('Y'), $this->getMonth(), $day);
        return $this;
    }

    /**
     * Добавить месяц к дате
     * @param int $count
     * @return $this
     */
    public function addMonth($count=1)
    {
        $count = (int) $count;
        $this->modify("{$count} month");

        return $this;
    }

    public function getMonth($cyrillic = false)
    {
        if ($cyrillic) {
            return self::$monthes_cyrillic[(int) $this->format('m')];
        } else {
            return (int) $this->format('m');
        }
    }

    public function getYear()
    {
        return (int) $this->format('Y');
    }

    /**
     * Установить дату на начало месяца
     * @return $this
     */
    public function setToFirstDayOfMonth()
    {
        $this->setDate((int)$this->format('Y'), (int)$this->format('m'), 1);

        return $this;
    }

    /**
     * Установить дату на конец месяца
     * @return $this
     */
    public function setToLastDayOfMonth()
    {
        $this->setDate((int)$this->format('Y'), (int)$this->format('m'), (int)$this->format('t'));

        return $this;
    }

    /**
     * Является ли текущий день последним днем месяца
     * @return bool
     */
    public function isLastDayOfMonth()
    {
        return (int)$this->format('t') == (int)$this->format('d');
    }

    /**
     * Возвращает количество дней в текущем месяце
     * @return int
     */
    public function daysInMonth()
    {
        return (int)$this->format('t');
    }

    /**
     * Очистить время
     * @return $this
     */
    public function clearTime()
    {
        $this->setTime(0, 0, 0);

        return $this;
    }

    /**
     * Возвращает строковое представление даты в человечном виде
     * @param bool $time возвращать ли время
     * @return string
     */
    public function toStringRus($time=false)
    {
        return $this->format('d.m.Y' . ($time?" H:i:s":""));
    }

    /**
     * Возвращает строковое представление даты в формате SQL
     * @param bool $time возвращать ли время
     * @return string
     */
    public function toStringSql($time=false)
    {
        return $this->format('Y-m-d' . ($time?" H:i:s":""));
    }
}
