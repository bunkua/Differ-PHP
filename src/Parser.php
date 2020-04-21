<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parse($data, $dataFormat)
{
    switch ($dataFormat) {
        case "json":
            return json_decode($data);
        case "yml":
            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
        default:
            throw new \Exception("Wrong file format '$dataFormat' or not supported");
    }
}
