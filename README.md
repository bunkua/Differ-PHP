## Differ

[![Maintainability](https://api.codeclimate.com/v1/badges/9dd6d63f9ffdaaa1956f/maintainability)](https://codeclimate.com/github/bunkua/php-project-lvl2/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/9dd6d63f9ffdaaa1956f/test_coverage)](https://codeclimate.com/github/bunkua/php-project-lvl2/test_coverage)
![Differ](https://github.com/bunkua/php-project-lvl2/workflows/Differ/badge.svg?branch=master)


### Description
This package calculates the difference between two JSON or YAML files. In addition, 3 different output formats are supported: `plain`, `pretty` and `json`.

### Install


- You need to Composer has been installed.

Execute this command to install package globally:

```
composer global require bunkua/hexlet_php_project2
```
[![asciicast](https://asciinema.org/a/IQVGvNjvNarl3jDmdBhRltkXL.svg)](https://asciinema.org/a/IQVGvNjvNarl3jDmdBhRltkXL)


### Usage
Execute in bash:

```
gendiff [--format <fmt>] <firstFile> <secondFile>
```

Format is optional and have `pretty` output format by default. So you don't need to specify a format and can execute like this:
```
gendiff <firstFile> <secondFile>
```
or explicitly specifying the desired format:
```
gendiff --format pretty <firstFile> <secondFile>
```
[![asciicast](https://asciinema.org/a/7vfFQBJbYW78RmhperVMnOW2L.svg)](https://asciinema.org/a/7vfFQBJbYW78RmhperVMnOW2L)


```
gendiff --format plain <firstFile> <secondFile>
```
[![asciicast](https://asciinema.org/a/HcOeM8lMPCCQNhc4EXXDDrPeb.svg)](https://asciinema.org/a/HcOeM8lMPCCQNhc4EXXDDrPeb)


```
gendiff --format json <firstFile> <secondFile>
```
[![asciicast](https://asciinema.org/a/ARWtpcoGigeTGOfCg9PdmZICv.svg)](https://asciinema.org/a/ARWtpcoGigeTGOfCg9PdmZICv)


### Usage as a package

You can use Differ as a package.
To do so you need add dependency to your `composer.json` file:
```
composer require bunkua/php-project-2
```
Then you will be able to use it in next way:
```
$differrence = \Differ\genDiff($pathToFileBefore, $pathToFileAfter, $outputFormat);
```
