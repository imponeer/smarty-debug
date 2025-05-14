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

## Setup

### Basic Setup

To register the debug extension with Smarty, add the extension class to your Smarty instance:

```php
// Create a Smarty instance
$smarty = new \Smarty\Smarty();

// Register the debug extension
$smarty->addExtension(new \Imponeer\Smarty\Extensions\Debug\DebugExtension());
```

### Using with Symfony Container

To integrate with Symfony, you can leverage autowiring, which is the recommended approach for modern Symfony applications:

```yaml
# config/services.yaml
services:
    # Enable autowiring and autoconfiguration
    _defaults:
        autowire: true
        autoconfigure: true

    # Register your application's services
    App\:
        resource: '../src/*'
        exclude: '../src/{DependencyInjection,Entity,Tests,Kernel.php}'

    # Configure Smarty with the extension
    # The DebugExtension will be autowired automatically
    \Smarty\Smarty:
        calls:
            - [addExtension, ['@Imponeer\Smarty\Extensions\Debug\DebugExtension']]
```

Then in your application code, you can simply retrieve the pre-configured Smarty instance:

```php
// Get the Smarty instance with the debug extension already added
$smarty = $container->get(\Smarty\Smarty::class);
```

### Using with PHP-DI

With PHP-DI container, you can take advantage of autowiring for a very simple configuration:

```php
use function DI\create;
use function DI\get;

return [
    // Configure Smarty with the extension
    \Smarty\Smarty::class => create()
        ->method('addExtension', get(\Imponeer\Smarty\Extensions\Debug\DebugExtension::class))
];
```

Then in your application code, you can retrieve the Smarty instance:

```php
// Get the configured Smarty instance
$smarty = $container->get(\Smarty\Smarty::class);
```

### Using with League Container

If you're using League Container, you can register the extension like this:

```php
// Create the container
$container = new \League\Container\Container();

// Register Smarty with the debug extension
$container->add(\Smarty\Smarty::class, function() {
    $smarty = new \Smarty\Smarty();
    // Configure Smarty...

    // Create and add the debug extension
    $extension = new \Imponeer\Smarty\Extensions\Debug\DebugExtension();
    $smarty->addExtension($extension);

    return $smarty;
});
```

Then in your application code, you can retrieve the Smarty instance:

```php
// Get the configured Smarty instance
$smarty = $container->get(\Smarty\Smarty::class);
```


## Using from templates

Debuging variables can be done from templates...

...with `debug_print_var` modifier:
```smarty
{"_AD_INSTALLEDMODULES"|debug_print_var}
```
## Development

### Code Quality Tools

This project uses several tools to ensure code quality:

- **PHPUnit** - For unit testing
  ```bash
  composer test
  ```

- **PHP CodeSniffer** - For coding standards (PSR-12)
  ```bash
  composer phpcs    # Check code style
  composer phpcbf   # Fix code style issues automatically
  ```

- **PHPStan** - For static analysis
  ```bash
  composer phpstan
  ```

## How to contribute?

If you want to add some functionality or fix bugs, you can fork, change and create pull request. If you not sure how this works, try [interactive GitHub tutorial](https://skills.github.com).

If you found any bug or have some questions, use [issues tab](https://github.com/imponeer/smarty-debug/issues) and write there your questions.
