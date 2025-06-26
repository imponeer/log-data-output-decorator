<?php

namespace Imponeer\Decorators\LogDataOutput;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Small decorator that extends @Symfony OutputInterface delivered class with few options for easier to log data
 *
 * @package Imponeer\Decorators\LogDataOutput
 */
class OutputDecorator implements OutputInterface
{
    /**
     * Ident for each line in left
     *
     * @noinspection PropertyCanBePrivateInspection
     */
    protected int $indent = 0;

    /**
     * OutputDecorator constructor.
     *
     * @param OutputInterface $output Output interface where this decorator will write
     *
     * @noinspection PropertyCanBePrivateInspection
     */
    public function __construct(
        protected readonly OutputInterface $output
    ) {
    }

    /**
     * Increases indent
     */
    public function incrIndent(): void
    {
        $this->indent++;
    }

    /**
     * Decreases indent
     */
    public function decrIndent(): void
    {
        $this->indent--;
    }

    /**
     * Resets indent
     */
    public function resetIndent(): void
    {
        $this->indent = 0;
    }

    /**
     * Prints fatal message
     *
     * @param string $message Message to print
     * @param string|int|float|bool|null ...$params Params for parsing message
     */
    public function fatal(string $message, string|int|float|bool|null ...$params): void
    {
        $this->write('<error>' . vsprintf($message, $params) . '</error>', true);
    }

    /**
     * Renders current indent string
     *
     * @return string
     */
    public function renderIndentString(): string
    {
        return str_repeat(' ', $this->indent * 2);
    }

    /**
     * @inheritDoc
     * @param iterable<string>|string $messages
     */
    public function write(iterable|string $messages, bool $newline = false, int $options = self::OUTPUT_NORMAL): void
    {
        if ($this->indent > 0) {
            $tmpMsg = '';
            if (is_string($messages)) {
                foreach (explode(PHP_EOL, $messages) as $line) {
                    $tmpMsg .= $this->renderIndentString() . $line . PHP_EOL;
                }
                $messages = rtrim($tmpMsg);
            }
        }

        $this->output->write($messages, $newline, $options);
    }

    /**
     * Prints success message
     *
     * @param string $message Message to print
     * @param string|int|float|bool|null ...$params Params for parsing message
     */
    public function success(string $message, string|int|float|bool|null ...$params): void
    {
        $this->write('<info>' . vsprintf($message, $params) . '</info>', true);
    }

    /**
     * Prints error message
     *
     * @param string $message Message to print
     * @param string|int|float|bool|null ...$params Params for parsing message
     */
    public function error(string $message, string|int|float|bool|null ...$params): void
    {
        $this->write('<error>' . vsprintf($message, $params) . '</error>', true);
    }

    /**
     * Prints info message
     *
     * @param string $message Message to print
     * @param string|int|float|bool|null ...$params Params for parsing message
     */
    public function info(string $message, string|int|float|bool|null ...$params): void
    {
        $this->write('<comment>' . vsprintf($message, $params) . '</comment>', true);
    }

    /**
     * Prints simple message
     *
     * @param string $message Message to print
     * @param string|int|float|bool|null ...$params Params for parsing message
     */
    public function msg(string $message, string|int|float|bool|null ...$params): void
    {
        $this->write(vsprintf($message, $params), true);
    }

    /**
     * @inheritDoc
     * @param iterable<string>|string $messages
     */
    public function writeln(iterable|string $messages, int $options = 0): void
    {
        $this->write($messages, true, $options);
    }

    /**
     * @inheritDoc
     */
    public function setVerbosity(int $level): void
    {
        $this->output->setVerbosity($level);
    }

    /**
     * @inheritDoc
     */
    public function getVerbosity(): int
    {
        return $this->output->getVerbosity();
    }

    /**
     * @inheritDoc
     */
    public function isQuiet(): bool
    {
        return $this->output->isQuiet();
    }

    /**
     * @inheritDoc
     */
    public function isVerbose(): bool
    {
        return $this->output->isVerbose();
    }

    /**
     * @inheritDoc
     */
    public function isVeryVerbose(): bool
    {
        return $this->output->isVeryVerbose();
    }

    /**
     * @inheritDoc
     */
    public function isDebug(): bool
    {
        return $this->output->isDebug();
    }

    /**
     * @inheritDoc
     */
    public function setDecorated(bool $decorated): void
    {
        $this->output->setDecorated($decorated);
    }

    /**
     * @inheritDoc
     */
    public function isDecorated(): bool
    {
        return $this->output->isDecorated();
    }

    /**
     * Sets current output formatter instance.
     *
     * @param OutputFormatterInterface $formatter Output formatter
     */
    public function setFormatter(OutputFormatterInterface $formatter): void
    {
        $this->output->setFormatter($formatter);
    }

    /**
     * @inheritDoc
     */
    public function getFormatter(): OutputFormatterInterface
    {
        return $this->output->getFormatter();
    }
}
