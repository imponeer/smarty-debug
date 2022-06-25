[![License](https://img.shields.io/github/license/imponeer/smarty-debug.svg)](LICENSE)
[![GitHub release](https://img.shields.io/github/release/imponeer/smarty-debug.svg)](https://github.com/imponeer/smarty-debug/releases) [![Maintainability](https://api.codeclimate.com/v1/badges/79f89e2fe21c0076c29a/maintainability)](https://codeclimate.com/github/imponeer/smarty-debug/maintainability) [![PHP](https://img.shields.io/packagist/php-v/imponeer/smarty-debug.svg)](http://php.net) 
[![Packagist](https://img.shields.io/packagist/dm/imponeer/smarty-debug.svg)](https://packagist.org/packages/imponeer/smarty-debug)

# Smarty Debug

This library provides some Smarty template plugins for adding new language keywords for debugging templates. 

## Installation

To install and use this package, we recommend to use [Composer](https://getcomposer.org):

```bash
composer require imponeer/smarty-debug
```

Otherwise, you need to include manually files from `src/` directory. 

## Registering in Smarty

If you want to use these extensions from this package in your project you need register them with [`registerPlugin` function](https://www.smarty.net/docs/en/api.register.plugin.tpl) from [Smarty](https://www.smarty.net). For example:
```php
$smarty = new \Smarty();
$debugPrintVarModifierPlugin = new \Imponeer\Smarty\Extensions\Debug\DebugPrintVarModifier();
$smarty->registerPlugin('modifier', $debugPrintVarModifierPlugin->getName(), [$debugPrintVarModifierPlugin, 'execute']);
```

## Using from templates

Debuging variables can be done from templates...

...with `debug_print_var` modifier:
```smarty
{"_AD_INSTALLEDMODULES"|debug_print_var}
```
## How to contribute?

If you want to add some functionality or fix bugs, you can fork, change and create pull request. If you not sure how this works, try [interactive GitHub tutorial](https://skills.github.com).

If you found any bug or have some questions, use [issues tab](https://github.com/imponeer/smarty-debug/issues) and write there your questions.
