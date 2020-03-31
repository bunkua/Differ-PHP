<?php

namespace Differ;

use PHPUnit\Framework\TestCase;

class GendiffTest extends TestCase
{
    /**
    * @dataProvider dataProvider
    */
    public function testgenDiff($pathBefore, $pathAfter, $resultPath)
    {
        $expected = file_get_contents($resultPath);

        $this->assertEquals($expected, genDiff($pathBefore, $pathAfter, 'pretty'));
    }

    public function dataProvider()
    {
        return [
            [
                'tests/fixtures/json/before.json',
                'tests/fixtures/json/after.json',
                'tests/fixtures/pretty_plain.txt'
            ],
            [
                'tests/fixtures/yaml/before.yaml',
                'tests/fixtures/yaml/after.yml',
                'tests/fixtures/pretty_plain.txt'
            ]
        ];
    }
}
