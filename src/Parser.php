<?php

namespace Parser;

function parse($filepath)
{
    $parse = function ($path) {
        $fileFormat = pathinfo($path, PATHINFO_EXTENSION);

        if (file_exists($path)) {
            $fileContents = file_get_contents($path);
        } else {
            echo "No such file \"{$path}\" \n";
            return null;
        }

        switch ($fileFormat) {
            case "json":
                return json_decode($fileContents, true);
            default:
                return;
        }
    };

    return $parse($filepath);
}
