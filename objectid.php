<?php

class ObjectID
{
    private static $MACHINE_ID, $index, $pid;

    private static function init()
    {
        self::$MACHINE_ID = intval(self::rand() * 0xFFFFFF);
        self::$index = intval(self::rand() * 0xFFFFFF);
        self::$pid = getmypid() % 0xFFFF;
    }

    private static function rand()
    {
        return mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
    }

    private static function hex($length, $n)
    {
        $n = dechex($n);
        return (strlen($n) == $length)? $n : str_repeat("0", $length-strlen($n)) . $n;
    }

    private static function next()
    {
        return self::$index = (self::$index + 1) % 0xFFFFFF;
    }

    public static function generate()
    {
        self::init();

        $time = round(microtime(true));

        return self::hex(8, $time) . 
               self::hex(6, self::$MACHINE_ID) .
               self::hex(4, self::$pid) . 
               self::hex(6, self::next());
    }
}
