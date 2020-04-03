<?php

namespace Differ;

use function Parser\parse;
use function Builder\buildTree;
use function Render\render;

function genDiff($pathToFile1, $pathToFile2, $outputFormat)
{
    try {
        $firstFileTree = parse($pathToFile1);
        $secondFileTree = parse($pathToFile2);

        $diffTree = buildTree($firstFileTree, $secondFileTree);

        return render($diffTree, $outputFormat);
    } catch (\Exception $e) {
        echo "ERROR: ", $e->getMessage(), "\n";
    }
}
