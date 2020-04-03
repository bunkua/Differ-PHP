## Differ

[![Maintainability](https://api.codeclimate.com/v1/badges/9dd6d63f9ffdaaa1956f/maintainability)](https://codeclimate.com/github/bunkua/php-project-lvl2/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/9dd6d63f9ffdaaa1956f/test_coverage)](https://codeclimate.com/github/bunkua/php-project-lvl2/test_coverage)
![Differ](https://github.com/bunkua/php-project-lvl2/workflows/Differ/badge.svg?branch=master)


### Description
This package calculates the difference between two JSON or YAML files. In addition, 3 different output formats are supported: `plain`, `pretty` and `json`.

### Install


- You need to Composer is installed.

Execute this command to install package globally:

```
composer global require bunkua/hexlet_php_project2
```

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

```
gendiff --format plain <firstFile> <secondFile>
```

```
gendiff --format json <firstFile> <secondFile>
```
