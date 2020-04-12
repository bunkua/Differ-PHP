<?php

namespace Differ\Reader;

function read($filepath)
{
    if (file_exists($filepath)) {
        return file_get_contents($filepath);
    } else {
        throw new \Exception("File '$filepath' does not exists");
    }
}

function getFileFormat($filepath)
{
    $fileExtension = pathinfo($filepath, PATHINFO_EXTENSION);
    
    return $fileExtension == 'yaml' ? 'yml' : $fileExtension;
}
