<?php

namespace Differ;

use function Differ\Parser\parse;
use function Differ\Builder\buildTree;
use function Differ\Render\render;

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
