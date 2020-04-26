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
        $beforePath = $this->getPath($inputFormat, $this->getFilename('before', $inputFormat));
        $afterPath = $this->getPath($inputFormat, $this->getFilename('after', $inputFormat));
        $resultPath = $this->getPath($this->getFilename($outputFormat, 'txt'));
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
    private function getFilename($name, $extension)
    {
        return implode('.', [$name, $extension]);
    }

    private function getPath(...$args)
    {
        $fixturesPath = $this->fixturesPath;

        return implode('/', [$fixturesPath, ...$args]);
    }
}
