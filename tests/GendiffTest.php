<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

class GendiffTest extends TestCase
{
    /**
    * @dataProvider dataProvider
    */
    public function testgenDiff($inputFormat, $outputFormat)
    {
        $fixturesPath = "tests/fixtures";
        $beforePath = "{$fixturesPath}/{$inputFormat}/before.{$inputFormat}";
        $afterPath = "{$fixturesPath}/{$inputFormat}/after.{$inputFormat}";
        $resultPath = "{$fixturesPath}/{$outputFormat}.txt";
        $expected = file_get_contents($resultPath);

        $this->assertEquals($expected, \Differ\Differ\genDiff($beforePath, $afterPath, $outputFormat));
    }

    public function dataProvider()
    {
        return [
            ['json', 'pretty'],
            ['json', 'plain'],
            ['json', 'json'],
            ['yaml', 'pretty'],
            ['yaml', 'plain'],
            ['yaml', 'json']
        ];
    }
}
