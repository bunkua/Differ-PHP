<?php

namespace Differ;

function run()
{
    $currentDir = dirname(__FILE__);
    $doc = file_get_contents($currentDir . '/helpfile.docopt');
  
    $args = \Docopt::handle($doc, array('version' => 'dev'));
    $pathToFile1 = $args->args['<firstFile>'];
    $pathToFile2 = $args->args['<secondFile>'];

    $firstFileJson = file_get_contents(getcwd() . "/$pathToFile1");
    $secondFileJson = file_get_contents(getcwd() . "/$pathToFile2");

    return genDiff($firstFileJson, $secondFileJson);
}
