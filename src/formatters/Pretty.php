<?php

namespace Differ\Formatters\Pretty;

const INDENT_SPACES = 4;

function pretty($tree, $nestingLevel = 0)
{
    $preparedStrings = array_map(function ($item) use ($nestingLevel) {
        return processNode($item, $nestingLevel + 1);
    }, $tree);

    return putBraces($preparedStrings, $nestingLevel);
}

function processNode($node, $nestingLevel)
{
    $key = $node['key'];
    $baseIndent = makeIndent($nestingLevel);
    $indentNew = substr_replace($baseIndent, "+", -2, 1);
    $indentOld = substr_replace($baseIndent, "-", -2, 1);

    switch ($node['status']) {
        case 'nested':
            return "{$baseIndent}{$key}: " . pretty($node['children'], $nestingLevel);
        case 'added':
            return "{$indentNew}{$key}: " . processValue($node['newValue'], $nestingLevel);
        case 'removed':
            return "{$indentOld}{$key}: " . processValue($node['oldValue'], $nestingLevel);
        case 'unchanged':
            return "{$baseIndent}{$key}: " . processValue($node['newValue'], $nestingLevel);
        case 'changed':
            $new = "{$indentNew}{$key}: " . processValue($node['newValue'], $nestingLevel);
            $old = "{$indentOld}{$key}: " . processValue($node['oldValue'], $nestingLevel);
            return "{$new}\n{$old}";
        default:
            return null;
    }
}

function processValue($value, $nestingLevel)
{
    if (is_object($value)) {
        $valueArr = (array) $value;
        $func = function ($key, $item) use ($nestingLevel) {
            $indent = makeIndent($nestingLevel + 1);
            return "{$indent}{$key}: {$item}";
        };
        $mappedValue = array_map($func, array_keys($valueArr), $valueArr);
        return putBraces($mappedValue, $nestingLevel);
    }

    if (is_array($value)) {
        $string = implode(", ", $value);
        return "[{$string}]";
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    return $value;
}

function makeIndent($level)
{
    return str_repeat(' ', $level * INDENT_SPACES);
}

function putBraces($prepared, $level)
{
    $openingBrace = "{\n";
    $closingBrace = makeIndent($level) . "}";
    $string = implode("\n", $prepared) . "\n";

    return "{$openingBrace}{$string}{$closingBrace}";
}
