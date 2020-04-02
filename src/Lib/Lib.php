<?php

namespace Lib;

function reduce($tree, $handle, $pointer)
{
    $func = function ($acc, $node) use ($handle, $pointer) {
        $add = $handle($node, $pointer);
        $acc = array_merge($acc, $add);
        return $acc;
    };

    return array_reduce($tree, $func, []);
}
