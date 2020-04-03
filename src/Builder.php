<?php

namespace Builder;

use function Funct\Collection\union;

function buildTree($firstTree, $secondTree)
{
    $firstTreeKeys = array_keys($firstTree);
    $secondTreeKeys = array_keys($secondTree);
    $treeKeys = union($firstTreeKeys, $secondTreeKeys);

    $makeNode = function ($key) use ($firstTree, $secondTree) {
        $firstIsObject = isset($firstTree[$key]) && is_object($firstTree[$key]);
        $secondIsObject = isset($secondTree[$key]) && is_object($secondTree[$key]);

        if ($firstIsObject && $secondIsObject) {
            $before = (array) $firstTree[$key];
            $after = (array) $secondTree[$key];
            return ["key" => $key, "children" => buildTree($before, $after)];
        }
        if (!array_key_exists($key, $firstTree)) {
            return buildNodeData("added", $key, null, $secondTree[$key]);
        }

        if (!array_key_exists($key, $secondTree)) {
            return buildNodeData("removed", $key, $firstTree[$key], null);
        }

        if ($firstTree[$key] === $secondTree[$key]) {
            return buildNodeData("unchanged", $key, $firstTree[$key], $secondTree[$key]);
        } else {
            return buildNodeData("changed", $key, $firstTree[$key], $secondTree[$key]);
        }
    };

    return array_map($makeNode, $treeKeys);
}

function buildNodeData($status, $key, $oldValue, $newValue)
{
    return [
        "status" => $status,
        "key" => $key,
        "oldValue" => $oldValue,
        "newValue" => $newValue
    ];
}
