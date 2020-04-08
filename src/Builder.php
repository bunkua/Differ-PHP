<?php

namespace Differ\Builder;

use function Funct\Collection\union;

function buildTree($firstTree, $secondTree)
{
    $firstTreeArr = is_object($firstTree) ? (array) $firstTree : $firstTree;
    $secondTreeArr = is_object($secondTree) ? (array) $secondTree : $secondTree;

    $firstTreeKeys = array_keys($firstTreeArr);
    $secondTreeKeys = array_keys($secondTreeArr);
    $treeKeys = union($firstTreeKeys, $secondTreeKeys);

    $makeNode = function ($key) use ($firstTreeArr, $secondTreeArr) {
        $firstIsObject = isset($firstTreeArr[$key]) && is_object($firstTreeArr[$key]);
        $secondIsObject = isset($secondTreeArr[$key]) && is_object($secondTreeArr[$key]);

        if ($firstIsObject && $secondIsObject) {
            $before = $firstTreeArr[$key];
            $after = $secondTreeArr[$key];
            return ["key" => $key, "children" => buildTree($before, $after)];
        }
        if (!array_key_exists($key, $firstTreeArr)) {
            return buildNodeData("added", $key, null, $secondTreeArr[$key]);
        }

        if (!array_key_exists($key, $secondTreeArr)) {
            return buildNodeData("removed", $key, $firstTreeArr[$key], null);
        }

        if ($firstTreeArr[$key] === $secondTreeArr[$key]) {
            return buildNodeData("unchanged", $key, $firstTreeArr[$key], $secondTreeArr[$key]);
        } else {
            return buildNodeData("changed", $key, $firstTreeArr[$key], $secondTreeArr[$key]);
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
