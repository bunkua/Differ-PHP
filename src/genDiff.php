<?php

namespace Differ;

function genDiff($firstFileJson, $secondFileJson)
{
    $decodedFile1 = json_decode($firstFileJson);
    $decodedFile2 = json_decode($secondFileJson);
}
