<?php

namespace Differ\Formatters\Json;

function json($tree)
{
    $prepared = reduce($tree);

    return json_encode($prepared, JSON_PRETTY_PRINT);
}

function map($tree)
{
    $func = function ($node) {
        $children = (array) $node['children'] ?? null;

        if ($children) {
            return [$node['key'] => map($children)];
        }
        $nodeValues = [
            'old' => $node['oldValue'] ?? null,
            'new' => $node['newValue'] ?? null
        ];
        $newValue = array_filter($nodeValues, function ($item) {
            return $item !== null;
        });

        return [$node['key'] => $newValue];
    };
    return array_map($func, $tree);
}

function reduce($tree)
{
    $func = function ($acc, $node) {
        $children = $node['children'] ?? null;
        $key = $node['key'];

        if ($children) {
            $acc[$key] = reduce($children);
            return $acc;
        }

        if ($node['status'] == 'unchanged') {
            $acc[$key] = $node['newValue'];
            return $acc;
        }

        $nodeValues = [
            'old' => $node['oldValue'] ?? null,
            'new' => $node['newValue'] ?? null
        ];
        $newValue = array_filter($nodeValues, function ($item) {
            return $item !== null;
        });

        $acc[$key] = $newValue;
        return $acc;
    };

    return array_reduce($tree, $func);
}
