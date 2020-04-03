<?php

namespace Render;

use function Formatters\Pretty\pretty;
use function Formatters\Plain\plain;
use function Formatters\Json\json;

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
                return json($tree);
            };
        case 'pretty':
            return function ($tree) {
                return pretty($tree);
            };
        default:
            throw new \Exception("Output format '$outputFormat' is wrong or not supported");
    }
}
