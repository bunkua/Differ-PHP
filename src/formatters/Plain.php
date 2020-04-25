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
            $string = "Property '{$currNestingPath}' was added with value: '{$newValue}'";
            break;
        case 'removed':
            $string = "Property '{$currNestingPath}' was removed";
            break;
        case 'changed':
            $newValue = stringifyValue($node['newValue']);
            $oldValue = stringifyValue($node['oldValue']);
            $string = "Property '{$currNestingPath}' was changed. From '{$oldValue}' to '{$newValue}'";
            break;
        case 'unchanged':
            return;
        default:
            throw new \Exception("Wrong node status: '{$node['status']}");
    }

    return $string;
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
