<?php

namespace Differ;

use function Parser\parse;
use function Builder\buildTree;
use function Render\render;

function genDiff($pathToFile1, $pathToFile2, $format)
{
    $firstFileTree = parse($pathToFile1);
    $secondFileTree = parse($pathToFile2);

    $diffTree = buildTree($firstFileTree, $secondFileTree);
    //var_dump($diffTree);

    return render($diffTree, $format);
}
