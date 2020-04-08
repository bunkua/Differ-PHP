<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parse($filepath)
{
    if (file_exists($filepath)) {
        $fileContents = file_get_contents($filepath);
    } else {
        throw new \Exception("File '$filepath' does not exists");
    }

    $parse = getParser($filepath);

    return $parse($fileContents);
}

function getParser($filepath)
{
    $fileExtension = pathinfo($filepath, PATHINFO_EXTENSION);
    $inputFileFormat = ($fileExtension == 'yaml') ? 'yml' : $fileExtension;

    return function ($fileContents) use ($inputFileFormat) {
        switch ($inputFileFormat) {
            case "json":
                return json_decode($fileContents);
            case "yml":
                return Yaml::parse($fileContents, Yaml::PARSE_OBJECT_FOR_MAP);
            default:
                throw new \Exception("Wrong file format '$inputFileFormat' or not supported");
        }
    };
}
