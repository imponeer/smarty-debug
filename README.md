[![License](https://img.shields.io/github/license/imponeer/smarty-debug.svg)](LICENSE)
[![GitHub release](https://img.shields.io/github/release/imponeer/smarty-debug.svg)](https://github.com/imponeer/smarty-debug/releases) [![PHP](https://img.shields.io/packagist/php-v/imponeer/smarty-debug.svg)](http://php.net)
[![Packagist](https://img.shields.io/packagist/dm/imponeer/smarty-debug.svg)](https://packagist.org/packages/imponeer/smarty-debug)
[![Smarty version requirement](https://img.shields.io/packagist/dependency-v/imponeer/debug-smarty/smarty%2Fsmarty)](https://smarty-php.github.io)


# Smarty Debug

> Powerful debugging tools for Smarty templates

This library extends Smarty with specialized debugging capabilities, allowing developers to easily inspect variables and troubleshoot template issues. It integrates with Symfony's VarDumper component to provide rich, formatted output of complex data structures directly in your templates.

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


## Usage

This extension provides modifiers that help with debugging variables in your Smarty templates.

### debug_print_var

The `debug_print_var` modifier displays the content of a variable in a human-readable format. It works with various data types including strings, numbers, booleans, arrays, and objects.

```smarty
{$variable|debug_print_var}
```

#### Examples

**Debugging a simple variable:**
```smarty
{"Hello World"|debug_print_var}
```

**Debugging an array:**
```smarty
{$userArray|debug_print_var}
```

**Debugging a template variable:**
```smarty
{$smarty.session|debug_print_var}
```

**Debugging a configuration variable:**
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

## Documentation

API documentation is automatically generated and available in the project's wiki. For more detailed information about the classes and methods, please refer to the [project wiki](https://github.com/imponeer/smarty-debug/wiki).

## Contributing

Contributions are welcome! Here's how you can contribute:

1. Fork the repository
2. Create a feature branch: `git checkout -b feature-name`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin feature-name`
5. Submit a pull request

Please make sure your code follows the PSR-12 coding standard and include tests for any new features or bug fixes.

If you find a bug or have a feature request, please create an issue in the [issue tracker](https://github.com/imponeer/smarty-debug/issues).
