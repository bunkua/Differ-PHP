<?php

namespace Render;

const NESTING_LEVEL = 1;

function render($tree, $format)
{
    $render = getRender($format);

}

function getRender($format)
{
    return function ($tree) use ($format) {
        switch ($format) {
            default:
                return pretty($tree);
        }
    };
}
