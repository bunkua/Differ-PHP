<?php

namespace Differ\Cli;

use Docopt;

use function Differ\Differ\genDiff;

function run()
{
    $doc = file_get_contents(__DIR__ . '/helpfile.docopt');

    $args = Docopt::handle($doc, array('version' => 'dev'));
    $pathToFile1 = $args->args['<firstFile>'];
    $pathToFile2 = $args->args['<secondFile>'];
    $format = $args->args["--format"];

    try {
        echo genDiff($pathToFile1, $pathToFile2, $format) . "\n";
    } catch (\Exception $e) {
        echo "ERROR in \Differ: " . $e->getMessage() . "\n";
    }
}
