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

        $this->assertEquals($expected, genDiff($pathBefore, $pathAfter, $format));
    }

    public function dataProvider()
    {
        return [
            [
                'tests/fixtures/json/before.json',
                'tests/fixtures/json/after.json',
                'tests/fixtures/pretty_plain.txt',
                'pretty'
            ],
            [
                'tests/fixtures/yaml/before.yaml',
                'tests/fixtures/yaml/after.yml',
                'tests/fixtures/pretty_plain.txt',
                'pretty'
            ],
            [
                'tests/fixtures/json/before2.json',
                'tests/fixtures/json/after2.json',
                'tests/fixtures/pretty_nested.txt',
                'pretty'
            ],
            [
                'tests/fixtures/yaml/before2.yaml',
                'tests/fixtures/yaml/after2.yml',
                'tests/fixtures/pretty_nested.txt',
                'pretty'
            ],
            [
                'tests/fixtures/json/before2.json',
                'tests/fixtures/json/after2.json',
                'tests/fixtures/plain_nested.txt',
                'plain'
            ],
            [
                'tests/fixtures/yaml/before2.yaml',
                'tests/fixtures/yaml/after2.yml',
                'tests/fixtures/plain_nested.txt',
                'plain'
            ]
        ];
    }
}
