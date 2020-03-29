<?php

namespace Render;

function render($tree, $format)
{
    switch ($format) {
        default:
            return pretty($tree);
    }
}
