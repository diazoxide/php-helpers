<?php
/**
 * Data type helper class
 * php version 7.2.10
 *
 * @category System\Helpers
 * @package  System\Helpers
 * @author   Aaron Yordanyan <aaron.yor@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @version  GIT: @1.0.1@
 * @link     https://github.com/dizoxide/php-helpers
 */

namespace diazoxide\helpers;

/**
 * Helper class for determine content types
 *
 * @category System\Helpers
 * @package  System\Helpers
 * @author   Aaron Yordanyan <aaron.yor@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link     https://github.com/NovemBit/i18n
 */
class DataType
{
    /**
     * Check if string is HTML
     *
     * @param string $string HTML string
     *
     * @return bool
     */
    public static function isHTMLFragment($string)
    {
        return $string !== strip_tags($string);
    }

    public static function isHTML($string)
    {
        return preg_match('/<html.*?>.*<\/html>/ims',$string) ? true : false;
    }

    public static function isXML($string): bool
    {
        return preg_match('/<\?xml.*\?>/ims',$string) ? true : false;
    }

    /**
     * Check if string is URL
     *
     * @param string $string URL string
     *
     * @return mixed
     */
    public static function isURL($string)
    {
        return filter_var($string, FILTER_VALIDATE_URL);
    }

    /**
     * Check if string is JSON
     *
     * @param string $string JSON string
     *
     * @return bool
     */
    public static function isJSON($string): bool
    {
        json_decode($string, true);
        return (json_last_error() === JSON_ERROR_NONE);
    }

    /**
     * Get type of string
     *  URL, JSON, HTML
     *
     * @param string $string String content
     *
     * @return string|null
     */
    public static function getType(string $string): ?string
    {
        if (self::isURL($string)) {
            return 'url';
        }

        if (self::isJSON($string)) {
            return 'json';
        }

        if (self::isXML($string)) {
            return 'xml';
        }

        if (self::isHTML($string)) {
            return 'html';
        }

        if (self::isHTMLFragment($string)) {
            return 'html_fragment';
        }

        return null;
    }
}