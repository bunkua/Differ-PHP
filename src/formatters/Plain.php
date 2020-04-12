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
            return "Property '{$currNestingPath}' was added with value: '{$newValue}'";
        case 'removed':
            return "Property '{$currNestingPath}' was removed";
        case 'changed':
            return "Property '{$currNestingPath}' was changed. From '{$oldValue}' to '{$newValue}'";
        default:
            return null;
    }
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
