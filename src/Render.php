<?php

namespace Render;

use function Formatters\Pretty\pretty;
use function Formatters\Plain\plain;

//use function Render\Json\json;

function render($tree, $format)
{
    $render = chooseRenderer($format);
    return $render($tree);
}

function chooseRenderer($format)
{
    switch ($format) {
        case 'plain':
            return function ($node) {
                return plain($node);
            };
        default:
            return function ($node) {
                return pretty($node);
            };
    }
}
