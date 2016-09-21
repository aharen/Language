<?php

namespace aharen\Language;

class StorageSession
{

    protected static $key;

    protected static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        self::$key = env('APP_SESSION_KEY');
        if (!isset($_SESSION[self::$key])) {
            $_SESSION[self::$key] = null;
        }
    }

    public static function put(array $data)
    {
        self::init();
        $_SESSION[self::$key] = serialize($data);
    }

    public static function get($string)
    {
        self::init();
        $data = unserialize($_SESSION[self::$key]);
        if (isset($data[$string])) {
            return $data[$string];
        }
    }

    public static function all()
    {
        self::init();
        return unserialize($_SESSION[self::$key]);
    }

    public static function pull($string)
    {
        self::init();
        $data = unserialize($_SESSION[self::$key]);
        if (isset($data[$string])) {
            $pulldata = $data[$string];
            unset($data[$string]);

            self::put($data);

            return $pulldata;
        }
    }
}
