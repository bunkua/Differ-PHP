<?php

namespace Differ\Render;

use function Differ\Formatters\Pretty\prettify;
use function Differ\Formatters\Plain\plainify;

function render($tree, $outputFormat)
{
    $render = chooseRenderer($outputFormat);
    
    return $render($tree);
}

function chooseRenderer($outputFormat)
{
    switch ($outputFormat) {
        case 'plain':
            return function ($tree) {
                return plainify($tree);
            };
        case 'json':
            return function ($tree) {
                return json_encode($tree, JSON_PRETTY_PRINT);
            };
        case 'pretty':
            return function ($tree) {
                return prettify($tree);
            };
        default:
            throw new \Exception("Output format '$outputFormat' is wrong or not supported");
    }
}
