<?php


namespace diazoxide\helpers;


use InvalidArgumentException;

class XML
{

    public static function encode(?string $content, $doubleEncode = true): string
    {
        return htmlspecialchars(
            $content,
            ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5,
            ini_get('default_charset'),
            $doubleEncode
        );
    }

    /**
     * @param  string  $content  the content to be decoded
     *
     * @return string the decoded content
     */
    public static function decode(string $content): string
    {
        return htmlspecialchars_decode($content, ENT_QUOTES);
    }

    /**
     * Array to html attributes string
     *
     * @param $data
     * @param  string|null  $parent
     *
     * @return string
     */
    public static function getAttrsString(array $data, ?string $parent = null): string
    {
        return implode(
            ' ',
            array_map(
                static function ($k, $v) use ($parent) {
                    if ($v === true) {
                        $v = 'true';
                    } elseif ($v === false) {
                        $v = 'false';
                    }

                    if (is_string($v)) {
                        $v = static::encode($v);
                        if ($parent === null && is_int($k)) {
                            return $v;
                        }
                        $k = ($parent ? $parent . '-' : '') . $k;

                        return $k . '="' . $v . '"';
                    }

                    if (is_array($v)) {
                        return self::getAttrsString($v, $k);
                    }

                    if (empty($v)) {
                        $k = ($parent ? $parent . '-' : '') . $k;

                        return $k . '=""';
                    }

                    $k = ($parent ? $parent . '-' : '') . $k;

                    return $k . '="' . json_encode($v) . '"';
                },
                array_keys($data),
                $data
            )
        );
    }

    /**
     * Open HTML Tag
     *
     * @param  string  $tag
     * @param  array|null  $attrs
     *
     * @param  string  $chars
     *
     * @return string
     */
    public static function tagOpen(string $tag, ?array $attrs = null, string $chars = '<>'): string
    {
        if ($attrs !== null) {
            $attrs_str = self::getAttrsString($attrs);
        }

        return sprintf(
            '%s%s%s%s',
            $chars[0] ?? '<',
            $tag,
            ! empty($attrs_str) ? ' ' . $attrs_str : '',
            $chars[1] ?? '>'
        );
    }

    /**
     * Close HTML tag
     *
     * @param  string  $tag
     *
     * @param  string  $chars
     *
     * @return string
     */
    public static function tagClose(string $tag, string $chars = '<>'): string
    {
        return sprintf('%s/%s%s', $chars[0] ?? '<', $tag, $chars[1] ?? '>');
    }

    /**
     * Print HTML Tag
     *
     * @param  string  $tag
     * @param  string|array  $content
     * @param  array|null  $attrs
     *
     * @param  string  $chars
     *
     * @return string
     */
    public static function tag(string $tag, $content = '', ?array $attrs = [], string $chars = '<>'): string
    {
        $html         = self::tagOpen($tag, $attrs, $chars);
        $content_html = '';

        $content = $content ?? '';

        if (is_array($content)) {
            foreach ($content as $_content) {
                $_content[3]  = $_content[3] ?? $chars;
                $content_html .= self::tag(...$_content);
            }
        } elseif (is_string($content)) {
            $content_html = $content;
        } else {
            throw new InvalidArgumentException('Invalid $content argument (string or array only).');
        }
        $html .= $content_html;
        $html .= self::tagClose($tag, $chars);

        return $html;
    }

    /**
     * @param $attr
     * @param $class
     */
    public static function addClass(&$attr, $class): void
    {
        $class = is_array($class) ? implode(' ', $class) : $class;
        if ( ! empty($attr)) {
            $attr .= ' ';
        }
        $attr .= $class;
    }
}