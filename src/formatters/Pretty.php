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
            $string = "{$baseIndent}{$key}: " . pretty($node['children'], $nestingLevel);
            break;
        case 'added':
            $string = "{$indentNew}{$key}: " . processValue($node['newValue'], $nestingLevel);
            break;
        case 'removed':
            $string = "{$indentOld}{$key}: " . processValue($node['oldValue'], $nestingLevel);
            break;
        case 'unchanged':
            $string = "{$baseIndent}{$key}: " . processValue($node['newValue'], $nestingLevel);
            break;
        case 'changed':
            $new = "{$indentNew}{$key}: " . processValue($node['newValue'], $nestingLevel);
            $old = "{$indentOld}{$key}: " . processValue($node['oldValue'], $nestingLevel);
            $string = "{$new}\n{$old}";
            break;
        default:
            return null;
    }

    return $string;
}

function processValue($value, $nestingLevel)
{
    if (is_string($value) || is_int($value)) {
        return $value;
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_array($value)) {
        $string = implode(", ", $value);
        return "[{$string}]";
    }

    $valueArr = (array) $value;
    $func = function ($key, $item) use ($nestingLevel) {
        $indent = makeIndent($nestingLevel + 1);
        return "{$indent}{$key}: {$item}";
    };

    $mappedValue = array_map($func, array_keys($valueArr), (array) $value);
    
    return putBraces($mappedValue, $nestingLevel);
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
