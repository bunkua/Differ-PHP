<?php

namespace Parser;

use Symfony\Component\Yaml\Yaml;

function parse($filepath)
{
    if (file_exists($filepath)) {
        $fileContents = file_get_contents($filepath);
    } else {
        return null;
    }

    $parse = getParser($filepath);

    return $parse($fileContents);
}

function getParser($filepath)
{
    $fileExtension = pathinfo($filepath, PATHINFO_EXTENSION);
    $format = ($fileExtension == 'yaml') ? 'yml' : $fileExtension;

    return function ($fileContents) use ($format) {
        switch ($format) {
            case "json":
                return (array) json_decode($fileContents);
            case "yml":
                return (array) Yaml::parse($fileContents, Yaml::PARSE_OBJECT_FOR_MAP);
            default:
                return;
        }
    };
}
