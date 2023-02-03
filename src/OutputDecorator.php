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
     * @var int
     */
    protected $indent = 0;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * OutputDecorator constructor.
     *
     * @param OutputInterface $originalOutput Output interface where this decorator will write
     */
    public function __construct(OutputInterface $originalOutput)
    {
        $this->output = $originalOutput;
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
     * @param mixed ...$params Params for parsing message
     */
    public function fatal(string $message, ...$params): void
    {
        $this->write('<error>' . vsprintf($message, $params) . '</error>', true);
    }

    /**
     * Renders current indent string
     *
     * @return string
     */
    public function renderIndentString(): string {
        return str_repeat(' ', $this->indent * 2);
    }

    /**
     * @inheritDoc
     */
    public function write($messages, $newline = false, $options = self::OUTPUT_NORMAL)
    {
        if ($this->indent > 0) {
            $tmpMsg = '';
            foreach (explode(PHP_EOL, $messages) as $line) {
                $tmpMsg .= $this->renderIndentString() . $line . PHP_EOL;
            }
            $messages = rtrim($tmpMsg);
        }
        /*if (trim($messages) == '') {
            return $this->output->write(var_export([$messages, debug_backtrace(false)[1]], true), $newline, $options);
        }*/
        return $this->output->write($messages, $newline, $options);
    }

    /**
     * Prints success message
     *
     * @param string $message Message to print
     * @param mixed ...$params Params for parsing message
     */
    public function success(string $message, ...$params): void
    {
        $this->write('<info>' . vsprintf($message, $params) . '</info>', true);
    }

    /**
     * Prints error message
     *
     * @param string $message Message to print
     * @param mixed ...$params Params for parsing message
     */
    public function error(string $message, ...$params): void
    {
        $this->write('<error>' . vsprintf($message, $params) . '</error>', true);
    }

    /**
     * Prints info message
     *
     * @param string $message Message to print
     * @param mixed ...$params Params for parsing message
     */
    public function info(string $message, ...$params): void
    {
        $this->write('<comment>' . vsprintf($message, $params) . '</comment>', true);
    }

    /**
     * Prints simple message
     *
     * @param string $message Message to print
     * @param mixed ...$params Params for parsing message
     */
    public function msg(string $message, ...$params): void
    {
        $this->write(vsprintf($message, $params), true);
    }

    /**
     * @inheritDoc
     */
    public function writeln($messages, $options = 0)
    {
        $this->write($messages, true, $options);
    }

    /**
     * @inheritDoc
     */
    public function setVerbosity($level)
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
    public function setDecorated($decorated): void
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