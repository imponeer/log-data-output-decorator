<?php

use Imponeer\Decorators\LogDataOutput\OutputDecorator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Output\BufferedOutput;

class OutputDecoratorTest extends TestCase
{
    /**
     * @var OutputDecorator
     */
    protected $decorator;
    /**
     * @var BufferedOutput
     */
    protected $output;

    protected function setUp(): void
    {
        $this->output = new BufferedOutput();
        $this->decorator = new OutputDecorator($this->output);

        parent::setUp();
    }

    public static function getTestData(): array {
        return [
            'writeln (simple)' => [
                'writeln',
                'test1',
            ],
            'success (simple)' => [
                'success',
                'test1',
            ],
            'error (simple)' => [
                'error',
                'test1',
            ],
            'info (simple)' => [
                'info',
                'test1',
            ],
            'msg (simple)' => [
                'msg',
                'test1',
            ],
            'fatal (simple)' => [
                'fatal',
                'test1',
            ],
            'success (with args)' => [
                'success',
                'test1 %s',
                [
                    'test2',
                ],
                'test1 test2',
            ],
            'error (with args)' => [
                'error',
                'test1 %s',
                [
                    'test2',
                ],
                'test1 test2',
            ],
            'info (with args)' => [
                'info',
                'test1 %s',
                [
                    'test2',
                ],
                'test1 test2',
            ],
            'msg (with args)' => [
                'msg',
                'test1 %s',
                [
                    'test2',
                ],
                'test1 test2',
            ],
            'fatal (with args)' => [
                'fatal',
                'test1 %s',
                [
                    'test2',
                ],
                'test1 test2',
            ],
        ];
    }

    protected function useDecoratorMethod(string $method, string $text, array $params): string {
        if (empty($params)) {
            $this->decorator->$method($text);
        } else {
            $args = $params;
            array_unshift($args, $text);
            call_user_func_array([$this->decorator, $method], $args);
        }

        return $this->output->fetch();
    }

    /**
     * @dataProvider getTestData
     */
    public function testIncrIndent(string $method, string $text, array $args = [], $shouldReturn = null): void {
        if ($shouldReturn === null) {
            $shouldReturn = $text;
        }

        $buffer = $this->useDecoratorMethod($method, $text, $args);
        $this->assertSame($shouldReturn . PHP_EOL, $buffer);

        $this->decorator->incrIndent();
        $buffer = $this->useDecoratorMethod($method, $text, $args);
        $this->assertNotSame($shouldReturn . PHP_EOL, $buffer);
        $this->assertSame($this->decorator->renderIndentString() . $shouldReturn . PHP_EOL, $buffer);

        $this->decorator->incrIndent();
        $buffer = $this->useDecoratorMethod($method, $text, $args);
        $this->assertNotSame($shouldReturn . PHP_EOL, $buffer);
        $this->assertSame($this->decorator->renderIndentString() . $shouldReturn . PHP_EOL, $buffer);
    }

    /**
     * @dataProvider getTestData
     */
    public function testDecrIndent(string $method, string $text, array $args = [], $shouldReturn = null): void
    {
        if ($shouldReturn === null) {
            $shouldReturn = $text;
        }

        $buffer = $this->useDecoratorMethod($method, $text, $args);
        $this->assertSame($shouldReturn . PHP_EOL, $buffer);

        $this->decorator->incrIndent();
        $this->decorator->decrIndent();

        $buffer = $this->useDecoratorMethod($method, $text, $args);
        $this->assertSame($shouldReturn . PHP_EOL, $buffer);
    }

    /**
     * @dataProvider getTestData
     */
    public function testResetIncr(string $method, string $text, array $args = [], $shouldReturn = null): void {
        if ($shouldReturn === null) {
            $shouldReturn = $text;
        }

        $buffer = $this->useDecoratorMethod($method, $text, $args);
        $this->assertSame($shouldReturn . PHP_EOL, $buffer);

        $this->decorator->incrIndent();
        $this->decorator->incrIndent();
        $this->decorator->incrIndent();
        $this->decorator->resetIndent();

        $buffer = $this->useDecoratorMethod($method, $text, $args);
        $this->assertSame($shouldReturn . PHP_EOL, $buffer);
    }

}