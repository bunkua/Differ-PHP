<?php

namespace Differ\Formatters\Plain;

function plain($tree, $nestingPath = '')
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

    if ($node['status'] === 'nested') {
        return plain($node['children'], $currNestingPath);
    }
    
    $newValue = getValue($node['newValue']);
    $oldValue = getValue($node['oldValue']);

    switch ($node['status']) {
        case 'added':
            $string = "Property '{$currNestingPath}' was added with value: '{$newValue}'";
            break;
        case 'removed':
            $string = "Property '{$currNestingPath}' was removed";
            break;
        case 'changed':
            $string = "Property '{$currNestingPath}' was changed. From '{$oldValue}' to '{$newValue}'";
            break;
        default:
            return null;
    }

    return $string;
}

function getValue($value)
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
