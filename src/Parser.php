<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parse($fileContents, $dataFormat)
{
    switch ($dataFormat) {
        case "json":
            return json_decode($fileContents);
            break;
        case "yml":
            return Yaml::parse($fileContents, Yaml::PARSE_OBJECT_FOR_MAP);
            break;
        default:
            throw new \Exception("Wrong file format '$dataFormat' or not supported");
    }
}
