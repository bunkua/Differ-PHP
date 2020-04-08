<?php

namespace Differ\Lib;

function reduce($tree, $handle, $pointer)
{
    $func = function ($acc, $node) use ($handle, $pointer) {
        $add = $handle($node, $pointer);
        
        return array_merge($acc, $add);
    };

    return array_reduce($tree, $func, []);
}
