<?php

namespace Differ\Differ;

use function Differ\Reader\read;
use function Differ\Reader\getFileFormat;
use function Differ\Parser\parse;
use function Differ\Builder\buildTree;
use function Differ\Render\render;

function genDiff($pathToFile1, $pathToFile2, $outputFormat)
{
        $firstFileContents = read($pathToFile1);
        $firstFileFormat = getFileFormat($pathToFile1);

        $secondFileContents = read($pathToFile2);
        $secondFileFormat = getFileFormat($pathToFile2);
        
        $firstFileData = parse($firstFileContents, $firstFileFormat);
        $secondFileData = parse($secondFileContents, $secondFileFormat);

        $diffTree = buildTree($firstFileData, $secondFileData);
        
        return render($diffTree, $outputFormat);
}
