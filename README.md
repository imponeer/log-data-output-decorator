[![License](https://img.shields.io/github/license/imponeer/log-data-output-decorator.svg)](LICENSE) [![GitHub release](https://img.shields.io/github/release/imponeer/log-data-output-decorator.svg)](https://github.com/imponeer/log-data-output-decorator/releases) [![PHP](https://img.shields.io/packagist/php-v/imponeer/log-data-output-decorator.svg)](http://php.net) [![Packagist](https://img.shields.io/packagist/dm/imponeer/log-data-output-decorator.svg)](https://packagist.org/packages/imponeer/log-data-output-decorator)

# Log Data Output Decorator

A decorator that extends [Symfony OutputInterface](https://github.com/symfony/console/blob/7.x/Output/OutputInterface.php) with:

- Multiple message types: info, success, error, fatal, and plain messages
- Automatic indentation with indent control methods
- Parameter substitution using sprintf formatting
- Full Symfony OutputInterface compatibility

## Installation

Install via [Composer](https://getcomposer.org):

```bash
composer require imponeer/log-data-output-decorator
```

## Usage

### Basic Usage

```php
use Imponeer\Decorators\LogDataOutput\OutputDecorator;
use Symfony\Component\Console\Output\ConsoleOutput;

$output = new OutputDecorator(new ConsoleOutput());

// Different message types
$output->info('This is an info message');
$output->success('Operation completed successfully');
$output->error('An error occurred');
$output->fatal('Critical error - application stopping');
$output->msg('Plain message without formatting');
```

### Indentation Support

```php
$output->info('Main process started');
$output->incrIndent();
$output->info('Sub-process 1');
$output->info('Sub-process 2');
$output->incrIndent();
$output->info('Nested sub-process');
$output->decrIndent();
$output->info('Back to sub-process level');
$output->resetIndent();
$output->info('Back to main level');
```

Output:
```
Main process started
  Sub-process 1
  Sub-process 2
    Nested sub-process
  Back to sub-process level
Back to main level
```

### Parameter Substitution

```php
$output->info('Processing file: %s', 'example.txt');
$output->success('Processed %d files in %s seconds', 42, '1.23');
$output->error('Failed to process %s: %s', 'file.txt', 'Permission denied');
```

### Advanced Example

```php
use Imponeer\Decorators\LogDataOutput\OutputDecorator;
use Symfony\Component\Console\Output\BufferedOutput;

$bufferedOutput = new BufferedOutput();
$output = new OutputDecorator($bufferedOutput);

$output->info('Starting batch process');
$output->incrIndent();

foreach (['file1.txt', 'file2.txt', 'file3.txt'] as $index => $file) {
    $output->info('Processing file %d: %s', $index + 1, $file);
    $output->incrIndent();

    if ($file === 'file2.txt') {
        $output->error('Failed to process %s', $file);
    } else {
        $output->success('Successfully processed %s', $file);
    }

    $output->decrIndent();
}

$output->resetIndent();
$output->info('Batch process completed');

// Get the formatted output
echo $bufferedOutput->fetch();
```

## API Documentation

Complete API documentation with all methods and examples is available in the [project wiki](https://github.com/imponeer/log-data-output-decorator/wiki), which is automatically generated from the source code.

## Testing

Run the test suite:

```bash
composer test
```

Check code style compliance:

```bash
composer phpcs
```

Fix code style issues automatically:

```bash
composer phpcbf
```

Run static analysis:

```bash
composer phpstan
```

## Contributing

We welcome contributions! Here's how you can help:

1. **Fork the repository** on GitHub
2. **Create a feature branch** (`git checkout -b feature/amazing-feature`)
3. **Make your changes** and add tests if applicable
4. **Run the test suite** to ensure everything works
5. **Commit your changes** (`git commit -am 'Add amazing feature'`)
6. **Push to the branch** (`git push origin feature/amazing-feature`)
7. **Create a Pull Request**

### Development Guidelines

- Follow PSR-12 coding standards
- Add tests for new functionality
- Update documentation for API changes
- Ensure all tests pass before submitting PR

### Reporting Issues

Found a bug or have a suggestion? Please [open an issue](https://github.com/imponeer/log-data-output-decorator/issues) with:

- Clear description of the problem or suggestion
- Steps to reproduce (for bugs)
- Expected vs actual behavior
- PHP and Symfony Console versions