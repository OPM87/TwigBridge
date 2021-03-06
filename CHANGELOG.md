## 1.1.3

- Allow Lavavel 8.x

## 1.1.2

- Allow Lavavel 7.x

## 1.1.1

- Allow Lavavel 6.x
- Merge from rcrowe/master

## 1.1.0

### Changed
- Allow Lavavel 5.8.x
- Merge from rcrowe/master

## 1.0.1

### Fixed
- Fixed namespace typo for using default FileViewFinder ([#2](https://github.com/OPM87/TwigBridge/pull/2))

## 1.0.0

First release since fork

- Custom (optional) FileViewFinder to allow autocompletion with symfony plugin (PHPStorm)
- Fixed tests
- Support Laravel 5.7
- Twig 2.x support
- Allow enable default cache with true option

## 0.8

Changes since 0.7

 - (Breaking) Normalize view events for included templates (folder/file.twig -> folder.file)
 - (initial) Twig 2.x support
 
## 0.7

Changes since 0.6

 - Support Laravel 5.x

## 0.6.0

Changes since 0.5.x

 - Support Laravel 4.2
 - Don't replace the ViewFactory to avoid package problems.
 - Improve the Twig syntax for calling aliases (#61)
 - Add Extensions for most used Laravel functions/filters (#99)
 - Improve template loading (#39, #60)
 - Compile twig files in `artisan optimize` command, extend CompilerEngine (#112)
 - Make better use of the IoC (#56, #119)
 - Improve Laravel composer / creator support (#59, #66)
 - Improve/simplify getAttributes() function
 - Render string templates (via ArrayLoader) (#94)

 - Improve error handling, use original source in Exceptions (#115)
