<?php

namespace Differ\Formatters\Plain;

function plainify($tree, $nestingPath = '')
{
    $preparedStrings = array_map(function ($node) use ($nestingPath) {
        return processNode($node, $nestingPath);
    }, $tree);

    $filteredStrings = array_filter($preparedStrings, function ($item) {
        return $item !== null;
    });

    return implode("\n", $filteredStrings);
}

function processNode($node, $nestingPath)
{
    $currNestingPath = ($nestingPath === '') ? $node['key'] : "{$nestingPath}.{$node['key']}";

    switch ($node['status']) {
        case 'nested':
            return plainify($node['children'], $currNestingPath);
        case 'added':
            $newValue = stringifyValue($node['newValue']);
            return "Property '{$currNestingPath}' was added with value: '{$newValue}'";
        case 'removed':
            return "Property '{$currNestingPath}' was removed";
        case 'changed':
            $newValue = stringifyValue($node['newValue']);
            $oldValue = stringifyValue($node['oldValue']);
            return "Property '{$currNestingPath}' was changed. From '{$oldValue}' to '{$newValue}'";
        case 'unchanged':
            return null;
        default:
            throw new \Exception("Wrong node status: '{$node['status']}");
    }
}

function stringifyValue($value)
{
    if (is_object($value)) {
        return 'complex value';
    }

    if (is_array($value)) {
        return 'Array';
    }
    
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    return $value;
}
