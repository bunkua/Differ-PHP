<?php

namespace Differ\Reader;

function read($filepath)
{
    if (!file_exists($filepath)) {
        throw new \Exception("File '$filepath' does not exists");
    }

    return file_get_contents($filepath);
}

function getFileFormat($filepath)
{
    $fileExtension = pathinfo($filepath, PATHINFO_EXTENSION);

    return $fileExtension == 'yaml' ? 'yml' : $fileExtension;
}
