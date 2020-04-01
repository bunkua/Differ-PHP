<?php

namespace Render;

use function Render\Pretty\pretty;
//use function Render\Plain\plain;
//use function Render\Json\json;

function render($tree, $format)
{
    $render = chooseRenderer($format);
    //var_dump($tree);
    return $render($tree);
}

function chooseRenderer($format)
{
    switch ($format) {
        default:
            return function ($node) {
                return pretty($node);
            };
    }
}
