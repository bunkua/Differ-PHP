<?php

namespace Differ\Differ;

use function Differ\Reader\read;
use function Differ\Reader\getFileFormat;
use function Differ\Parser\parse;
use function Differ\Builder\buildTree;
use function Differ\Render\render;

function genDiff($pathBefore, $pathAfter, $outputFormat)
{
        $beforeContent = read($pathBefore);
        $beforeFormat = getFileFormat($pathBefore);

        $afterContent = read($pathAfter);
        $afterFormat = getFileFormat($pathAfter);
        
        $beforeParsedData = parse($beforeContent, $beforeFormat);
        $afterParsedData = parse($afterContent, $afterFormat);

        $diffTree = buildTree($beforeParsedData, $afterParsedData);
        
        return render($diffTree, $outputFormat);
}
