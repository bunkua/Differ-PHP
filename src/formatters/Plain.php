<?php

namespace Formatters\Plain;

use function Lib\reduce;
use function Funct\Collection\flatten;

const BASE_POINTER = [];

function plain($tree, $pointer = BASE_POINTER)
{
    $preparedPlainData = makePlain($tree, $pointer);

    return implode("\n", flatten($preparedPlainData));
}

function makePlain($tree, $pointer)
{
    $preparedData = reduce($tree, function ($node, $pointer) {
        return processNode($node, $pointer);
    }, $pointer);

    return $preparedData;
}

function processNode($node, $pointer)
{
    $children = $node['children'] ?? null;
    $key = $node['key'];

    if ($children) {
        $currPointer = array_merge($pointer, [$key]);
        return makePlain($children, $currPointer);
    }

    return getMessage($node, $pointer);
}

function getMessage($node, $pointer)
{
    $status = $node['status'];
    $newValue = getValue($node['newValue']);
    $oldValue = getValue($node['oldValue']);

    $currPointer = implode('.', array_merge($pointer, [$node['key']]));

    switch ($status) {
        case 'added':
            return ["Property '{$currPointer}' was added with value: '{$newValue}'"];
        case 'removed':
            return ["Property '{$currPointer}' was removed"];
        case 'changed':
            return ["Property '{$currPointer}' was changed. From '{$oldValue}' to '{$newValue}'"];
        default:
            return [];
    }
}

function getValue($value)
{
    if (is_object($value)) {
        return 'complex value';
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    return $value;
}
