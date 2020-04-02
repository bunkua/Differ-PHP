<?php

namespace Render;

use function Formatters\Pretty\pretty;
use function Formatters\Plain\plain;
use function Formatters\Json\json;

function render($tree, $format)
{
    $render = chooseRenderer($format);
    return $render($tree);
}

function chooseRenderer($format)
{
    switch ($format) {
        case 'plain':
            return function ($tree) {
                return plain($tree);
            };
        case 'json':
            return function ($tree) {
                return json($tree);
            };
        default:
            return function ($tree) {
                return pretty($tree);
            };
    }
}
