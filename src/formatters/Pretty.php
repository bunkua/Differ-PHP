<?php

namespace Differ\Formatters\Pretty;

const INDENT_SPACES = 4;
const SIGN_SPACES = 2;

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
    $baseIndent = str_repeat(' ', $nestingLevel * INDENT_SPACES - SIGN_SPACES);

    $noSignSpace = "{$baseIndent}  ";
    $addSign = "{$baseIndent}+ ";
    $removeSign = "{$baseIndent}- ";

    switch ($node['status']) {
        case 'nested':
            $string = "{$noSignSpace}{$key}: " . pretty($node['children'], $nestingLevel);
            break;
        case 'added':
            $string = "{$addSign}{$key}: " . processValue($node['newValue'], $nestingLevel);
            break;
        case 'removed':
            $string = "{$removeSign}{$key}: " . processValue($node['oldValue'], $nestingLevel);
            break;
        case 'unchanged':
            $string = "{$noSignSpace}{$key}: " . processValue($node['newValue'], $nestingLevel);
            break;
        case 'changed':
            $new = "{$addSign}{$key}: " . processValue($node['newValue'], $nestingLevel);
            $old = "{$removeSign}{$key}: " . processValue($node['oldValue'], $nestingLevel);
            $string = "{$new}\n{$old}";
            break;
        default:
            throw new \Exception("Wrong node type");
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
