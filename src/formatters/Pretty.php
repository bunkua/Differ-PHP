<?php

namespace Formatters\Pretty;

use function Lib\reduce;

const BASE_INDENT_LEVEL = 0;
const INDENT_SPACES = 4;

function pretty($tree, $level = BASE_INDENT_LEVEL)
{
    $preparedTree = reduce($tree, function ($node, $level) {
        return processNode($node, $level);
    }, $level + 1);

    return putBraces($preparedTree, $level + 1);
}

function processNode($node, $level)
{
    $indent = makeIndent($level);
    $indentNew = substr_replace($indent, "+", -2, 1);
    $indentOld = substr_replace($indent, "-", -2, 1);

    $key = $node['key'];
    $children = $node['children'] ?? null;

    if ($children) {
        $childArr = (array) $children;
        $value = pretty($childArr, $level);
        return ["{$indent}{$key}: $value"];
    }

    if ($node['status'] == 'unchanged') {
        $value = processValue($node['newValue'], $level + 1);
        return ["{$indent}{$key}: {$value}"];
    }

    if ($node['status'] == 'added') {
        $value = processValue($node['newValue'], $level + 1);
        return ["{$indentNew}{$key}: {$value}"];
    }

    if ($node['status'] == 'removed') {
        $value = processValue($node['oldValue'], $level + 1);
        return ["{$indentOld}{$key}: {$value}"];
    }

    if ($node['status'] == 'changed') {
        $oldValue = processValue($node['oldValue'], $level + 1);
        $newValue = processValue($node['newValue'], $level + 1);
        return [
            "{$indentNew}{$key}: {$newValue}",
            "{$indentOld}{$key}: {$oldValue}"
        ];
    }
}

function makeIndent($level)
{
    return str_repeat(' ', $level * INDENT_SPACES);
}

function processValue($value, $level)
{
    if (is_object($value)) {
        $valueArr = (array) $value;
        $func = function ($key, $item) use ($level) {
            $indent = makeIndent($level);
            return "{$indent}{$key}: {$item}";
        };
        $mappedValue = array_map($func, array_keys($valueArr), $valueArr);
        return putBraces($mappedValue, $level);
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    return $value;
}

function putBraces($prepared, $level)
{
    $openingBrace = "{\n";
    $closingBrace = makeIndent($level - 1) . "}";
    $string = implode("\n", $prepared) . "\n";

    return "{$openingBrace}{$string}{$closingBrace}";
}
