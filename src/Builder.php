<?php

namespace Differ\Builder;

use function Funct\Collection\union;

function buildTree($before, $after)
{
    $makeNode = function ($propertyName) use ($before, $after) {
        if (!property_exists($before, $propertyName)) {
            return buildNodeData(
                "added",
                $propertyName,
                null,
                $after->$propertyName
            );
        }

        if (!property_exists($after, $propertyName)) {
            return buildNodeData(
                "removed",
                $propertyName,
                $before->$propertyName,
                null
            );
        }

        if (is_object($before->$propertyName) && is_object($after->$propertyName)) {
            return [
                'key' => $propertyName,
                'status' => 'nested',
                'children' => buildTree(
                    $before->$propertyName,
                    $after->$propertyName
                )
            ];
        }

        if ($before->$propertyName === $after->$propertyName) {
            return buildNodeData(
                "unchanged",
                $propertyName,
                $before->$propertyName,
                $after->$propertyName
            );
        } else {
            return buildNodeData(
                "changed",
                $propertyName,
                $before->$propertyName,
                $after->$propertyName
            );
        }
    };
    
    $propertyNames = getUniqueObjectKeys($before, $after);
    return array_map($makeNode, $propertyNames);
}

function getUniqueObjectKeys(...$objects)
{
    return array_reduce($objects, function ($acc, $object) {
        $objectVars = get_object_vars($object);
        $keys = array_keys($objectVars);
        $acc = array_merge($acc, $keys);
        return array_unique($acc);
    }, []);
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
