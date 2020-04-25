<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

class GendiffTest extends TestCase
{
    private $fixturesPath = "tests/fixtures";
    
    /**
    * @dataProvider dataProvider
    */
    public function testgenDiff($inputFormat, $outputFormat)
    {
        $beforePath = $this->getPath("{$inputFormat}/before.{$inputFormat}");
        $afterPath = $this->getPath("{$inputFormat}/after.{$inputFormat}");
        $resultPath = $this->getPath("{$outputFormat}.txt");
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

    private function getPath($fileName)
    {
        $fixturesPath = $this->fixturesPath;

        return "{$fixturesPath}/{$fileName}";
    }
}
