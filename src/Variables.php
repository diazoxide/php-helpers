<?php


namespace diazoxide\helpers;


class Variables
{

    /**
     * Compare
     *
     * 'equal' => 'Equal ( = )',
     * 'greater_than' => 'Greater than ( > )',
     * 'greater_than_or_equal' => 'Greater than or equal ( >= )',
     * 'less_than' => 'Less than ( < )',
     * 'less_than_or_equal' => 'Less than or equal ( <= )',
     * 'not' => 'Not ( <> )',
     * 'contains' => 'Contains ( %word% )',
     * 'regexp' => 'Regular expression ( /^(man|woman)$/ )'
     *
     * */
    public const COMPARE_EQUAL = 'equal';
    public const COMPARE_NOT_EQUAL = 'not_equal';
    public const COMPARE_GREATER_THAN = 'greater_than';
    public const COMPARE_GREATER_THAN_OR_EQUAL = 'greater_than_or_equal';
    public const COMPARE_LESS_THAN = 'less_than';
    public const COMPARE_LESS_THAN_OR_EQUAL = 'less_than_or_equal';
    public const COMPARE_CONTAINS = 'contains';
    public const COMPARE_REGEXP = 'regexp';
    public const COMPARE_STARTS_WITH = 'starts_with';
    public const COMPARE_ENDS_WITH = 'ends_with';

    /**
     * @param string|null $type
     * @param $a
     * @param $b
     * @return bool
     */
    public static function compare(?string $type, $a, $b): bool
    {
        if ($type === null || $type === self::COMPARE_EQUAL) {
            return $a == $b;
        }

        if ($type === self::COMPARE_NOT_EQUAL) {
            return $a != $b;
        }

        if ($type === self::COMPARE_GREATER_THAN) {
            return $a > $b;
        }

        if ($type === self::COMPARE_GREATER_THAN_OR_EQUAL) {
            return $a >= $b;
        }

        if ($type === self::COMPARE_LESS_THAN) {
            return $a < $b;
        }

        if ($type === self::COMPARE_LESS_THAN_OR_EQUAL) {
            return $a <= $b;
        }

        if ($type === self::COMPARE_REGEXP) {
            return (bool)preg_match($b, $a);
        }

        if ($type === self::COMPARE_CONTAINS) {
            return strpos($a, $b) !== false;
        }

        if ($type === self::COMPARE_STARTS_WITH) {
            return strpos($a, $b) === 0;
        }

        if ($type === self::COMPARE_ENDS_WITH) {
            $length = strlen($b);
            if ($length === 0) {
                return true;
            }
            return substr($a, -$length) === $b;
        }

        return false;
    }
}