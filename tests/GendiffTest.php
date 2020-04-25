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
        $beforePath = $this->getPath($inputFormat, 'before');
        $afterPath = $this->getPath($inputFormat, 'after');
        $resultPath = $this->getPath($outputFormat, 'result');
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

    private function getPath($format, $fileName)
    {
        $fixturesPath = $this->fixturesPath;

        if ($fileName === 'result') {
            return "{$fixturesPath}/{$format}.txt";
        }

        return "{$fixturesPath}/{$format}/{$fileName}.{$format}";
    }
}
