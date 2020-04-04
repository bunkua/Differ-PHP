<?php

namespace Differ\Engine;

function run()
{
    $doc = file_get_contents(__DIR__ . '/helpfile.docopt');

    $args = \Docopt::handle($doc, array('version' => 'dev'));
    $pathToFile1 = $args->args['<firstFile>'];
    $pathToFile2 = $args->args['<secondFile>'];
    $format = $args->args["--format"];

    echo genDiff($pathToFile1, $pathToFile2, $format) . "\n";
}
