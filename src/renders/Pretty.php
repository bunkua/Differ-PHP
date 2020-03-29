<?php

namespace Render;

function pretty($tree)
{
    $func = function ($acc, $node) {
        $acc = array_merge($acc, processNode($node));
        return $acc;
    };
    $result = array_reduce($tree, $func, []);
    return prepare($result);
}

function processNode($item)
{
    if ($item['status'] == 'added') {
        return ["+ {$item['key']}" => $item['newValue']];
    }
    if ($item['status'] == 'removed') {
        return ["- {$item['key']}" => $item['oldValue']];
    }

    if ($item['status'] == 'changed') {
        return [
            "+ {$item['key']}" => $item['newValue'],
            "- {$item['key']}" => $item['oldValue']
        ];
    }
    return ["  {$item['key']}" => $item['newValue']];
}

function prepare($data)
{
    $replace = ["\""];
    $prepared = json_encode($data, JSON_PRETTY_PRINT);
    $noQuotes = str_replace("\"", "", $prepared);
    $result = str_replace("\n  ", "\n", $noQuotes);
    return $result;
}
