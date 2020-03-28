<?php

namespace Differ;

function run()
{
    $currentDir = dirname(__FILE__);
    $doc = file_get_contents($currentDir . '/helpfile.docopt');

    $args = \Docopt::handle($doc, array('version' => 'dev'));
    $pathToFile1 = $args->args['<firstFile>'] ?? null;
    $pathToFile2 = $args->args['<secondFile>'] ?? null;
    $format = $args->args["--format"] ?? null;
    
    echo genDiff($pathToFile1, $pathToFile2, $format);
}
