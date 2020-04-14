<?php


namespace diazoxide\helpers;


use InvalidArgumentException;

class XML
{

    /**
     * Array to html attributes string
     *
     * @param $data
     * @param string|null $parent
     *
     * @return string
     */
    public static function getAttrsString(array $data, ?string $parent = null): string
    {
        return implode(
            ' ',
            array_map(
                static function ($k, $v) use ($parent) {
                    if (is_string($v)) {
                        $v = htmlspecialchars($v);
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
     * @param string $tag
     * @param array|null $attrs
     *
     * @return string
     */
    public static function tagOpen(string $tag, ?array $attrs = null): string
    {
        if ($attrs !== null) {
            $attrs_str = self::getAttrsString($attrs);
        }

        return sprintf(
            '<%s%s>',
            $tag,
            !empty($attrs_str) ? ' ' . $attrs_str : ''
        );
    }

    /**
     * Close HTML tag
     *
     * @param string $tag
     *
     * @return string
     */
    public static function tagClose(string $tag): string
    {
        return sprintf('</%s>', $tag);
    }

    /**
     * Print HTML Tag
     *
     * @param string $tag
     * @param string|array $content
     * @param array|null $attrs
     *
     * @return string
     */
    public static function tag(string $tag, $content = '', ?array $attrs = []): string
    {
        $html = self::tagOpen($tag, $attrs);
        $content_html = '';
        if (is_array($content)) {
            foreach ($content as $_content){
                $content_html.= self::tag(...$_content);
            }
        } elseif(is_string($content)){
            $content_html = $content;
        } else{
            throw new InvalidArgumentException('Invalid $content argument (string or array only).');
        }
        $html .= $content_html;
        $html .= self::tagClose($tag);

        return $html;
    }

    /**
     * @param $attr
     * @param $class
     */
    public static function addClass(&$attr, $class): void
    {
        $class = is_array($class) ? implode(' ', $class) : $class;
        if (!empty($attr)) {
            $attr .= ' ';
        }
        $attr .= $class;
    }
}