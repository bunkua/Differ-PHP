<?php

namespace Differ;

use PHPUnit\Framework\TestCase;

class GendiffTest extends TestCase
{
    public function testgenDiff()
    {
        $pathBefore = 'tests/fixtures/json/before.json';
        $pathAfter = 'tests/fixtures/json/after.json';
        $expected = file_get_contents("tests/fixtures/pretty_plain.txt");

        $this->assertEquals($expected, genDiff($pathBefore, $pathAfter, 'pretty'));
    }
}
