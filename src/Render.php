<?php

namespace Differ\Render;

use function Differ\Formatters\Pretty\pretty;
use function Differ\Formatters\Plain\plain;
use function Differ\Formatters\Json\json;

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
                return plain($tree);
            };
        case 'json':
            return function ($tree) {
                return json_encode($tree, JSON_PRETTY_PRINT);
            };
        case 'pretty':
            return function ($tree) {
                return pretty($tree);
            };
        default:
            throw new \Exception("Output format '$outputFormat' is wrong or not supported");
    }
}
