<?php

namespace Differ\Formatters\Pretty;

const INDENT_SPACES = 4;
const SIGN_SPACES = 2;

function prettify($tree, $depth = 0)
{
    $preparedStrings = array_map(function ($item) use ($depth) {
        return processNode($item, $depth + 1);
    }, $tree);

    return putBraces($preparedStrings, $depth);
}

function processNode($node, $depth)
{
    $key = $node['key'];
    $baseIndent = str_repeat(' ', $depth * INDENT_SPACES - SIGN_SPACES);

    $noSignSpace = "{$baseIndent}  ";
    $addSign = "{$baseIndent}+ ";
    $removeSign = "{$baseIndent}- ";

    switch ($node['status']) {
        case 'nested':
            return "{$noSignSpace}{$key}: " . prettify($node['children'], $depth);
        case 'added':
            return "{$addSign}{$key}: " . stringifyValue($node['newValue'], $depth);
        case 'removed':
            return "{$removeSign}{$key}: " . stringifyValue($node['oldValue'], $depth);
        case 'unchanged':
            return "{$noSignSpace}{$key}: " . stringifyValue($node['newValue'], $depth);
        case 'changed':
            $new = "{$addSign}{$key}: " . stringifyValue($node['newValue'], $depth);
            $old = "{$removeSign}{$key}: " . stringifyValue($node['oldValue'], $depth);
            return "{$new}\n{$old}";
        default:
            throw new \Exception("Wrong node status: '{$node['status']}");
    }
}

function stringifyValue($value, $depth)
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
    $func = function ($key, $item) use ($depth) {
        $indent = makeIndent($depth + 1);
        return "{$indent}{$key}: {$item}";
    };

    $mappedValue = array_map($func, array_keys($valueArr), (array) $value);
    
    return putBraces($mappedValue, $depth);
}

function makeIndent($depth)
{
    return str_repeat(' ', $depth * INDENT_SPACES);
}

function putBraces($prepared, $depth)
{
    $openingBrace = "{\n";
    $closingBrace = makeIndent($depth) . "}";
    $string = implode("\n", $prepared) . "\n";

    return "{$openingBrace}{$string}{$closingBrace}";
}
