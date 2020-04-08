<?php

namespace Differ;

use PHPUnit\Framework\TestCase;

class GendiffTest extends TestCase
{
    /**
    * @dataProvider dataProvider
    */
    public function testgenDiff($pathBefore, $pathAfter, $resultPath, $format)
    {
        $expected = file_get_contents($resultPath);

        $this->assertEquals($expected, Differ\genDiff($pathBefore, $pathAfter, $format));
    }

    public function dataProvider()
    {
        $resultPaths = [
            'tests/fixtures/pretty_nested.txt',
            'tests/fixtures/plain_nested.txt',
            'tests/fixtures/json_nested.txt'
        ];
        $formats = ['pretty', 'plain', 'json'];
        $jsonPaths = [
            'tests/fixtures/json/before2.json',
            'tests/fixtures/json/after2.json'
        ];
        $yamlPaths = [
            'tests/fixtures/yaml/before2.yaml',
            'tests/fixtures/yaml/after2.yml'
        ];

        $generateTestData = function ($sourcePaths) use ($resultPaths, $formats) {
            return array_map(function ($resultPath, $format) use ($sourcePaths) {
                return array_merge($sourcePaths, [$resultPath, $format]);
            }, $resultPaths, $formats);
        };

        $jsonTestData = $generateTestData($jsonPaths);
        $yamlTestData = $generateTestData($yamlPaths);

        return array_merge($jsonTestData, $yamlTestData);
    }
}
