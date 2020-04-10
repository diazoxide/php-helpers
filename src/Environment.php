<?php

namespace diazoxide\helpers;

/**
 * Class Environment
 */
class Environment
{

    /**
     * @param string|null $var
     * @param null $val
     * @return array|mixed|null
     */
    public static function request(?string $var = null, $val = null)
    {
        return self::global($_REQUEST, $var, $val);
    }

    /**
     * @param string|null $var
     * @param null $val
     * @return array|mixed|null
     */
    public static function cookie(?string $var = null, $val = null)
    {
        return self::global($_COOKIE, $var, $val);
    }

    /**
     * @param string|null $var
     * @param null $val
     * @return array|mixed|null
     */
    public static function server(?string $var = null, $val = null)
    {
        return self::global($_SERVER, $var, $val);
    }

    /**
     * @param string|null $var
     * @param null $val
     * @return array|mixed|null
     */
    public static function get(?string $var = null, $val = null)
    {
        return self::global($_GET, $var, $val);
    }

    /**
     * @param string|null $var
     * @param null $val
     * @return array|mixed|null
     */
    public static function post(?string $var = null, $val = null)
    {
        return self::global($_POST, $var, $val);
    }

    /**
     * @param $global
     * @param string|null $var
     * @param null $val
     * @return mixed|null
     */
    public static function global(array &$global, ?string $var = null, $val = null)
    {
        if ($var === null) {
            return $global ?? null;
        }
        if ($val === null) {
            return $global[$var] ?? null;
        }
        $global[$var] = $val;

        return $global[$var] ?? null;
    }
}

