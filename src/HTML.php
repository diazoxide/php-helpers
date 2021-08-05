<?php

namespace diazoxide\helpers;

class HTML extends XML
{
    public static function tag(string $tag, $content = '', ?array $attrs = [], string $chars = '<>'): string
    {
        return parent::tag($tag, $content, $attrs, '<>');
    }
}
