<?php

namespace GreenCape\REPL\Test;

use GreenCape\REPL\ReadEvalPrintLoop;
use GreenCape\REPL\Test\Evaluator\ExceptionIssuer;
use GreenCape\REPL\Test\Evaluator\Mocker;
use PHPUnit\Framework\TestCase;

/**
 * Class LoopTest
 *
 * @package GreenCape\REPL\Test
 */
class LoopTest extends TestCase
{
    /**
     * @testdox init() and exit() are called on the evaluator, query is evaluated
     *
     * @covers  \GreenCape\REPL\ReadEvalPrintLoop
     * @return void
     */
    public function testLoopSingleLine(): void
    {
        $evaluator = new Mocker();

        $input = fopen("php://temp/maxmemory:1024", 'r+');
        fputs($input, "user query\nexit\n");
        rewind($input);

        $loop = new ReadEvalPrintLoop($evaluator, $input);

        $this->expectOutputString(
            "> Query: user query\n> Bye!\n"
        );

        $loop->run();

        fclose($input);

        $this->assertSame(
            [
                'init',
                'user query',
                'exit',
            ],
            $evaluator->history
        );
    }

    /**
     * @testdox Lines ending with backslash signal continuation
     *
     * @covers  \GreenCape\REPL\ReadEvalPrintLoop
     * @return void
     */
    public function testLoopMultiLine(): void
    {
        $evaluator = new Mocker();

        $input = fopen("php://temp/maxmemory:1024", 'r+');
        fputs($input, "line one\\\nline two\nexit\n");
        rewind($input);

        $loop = new ReadEvalPrintLoop($evaluator, $input);

        ob_start();
        $loop->run();
        ob_end_clean();

        fclose($input);

        $this->assertSame(
            [
                'init',
                "line one\nline two",
                'exit',
            ],
            $evaluator->history
        );
    }

    /**
     * @testdox Exceptions are caught and printed
     *
     * @covers  \GreenCape\REPL\ReadEvalPrintLoop
     * @return void
     */
    public function testExceptionHandling(): void
    {
        $evaluator = new ExceptionIssuer();

        $input = fopen("php://temp/maxmemory:1024", 'r+');
        fputs($input, "user query\nexit\n");
        rewind($input);

        $loop = new ReadEvalPrintLoop($evaluator, $input);

        $this->expectOutputString(
            "> Error:\n1. user query\n2. Previous exception\n> Bye!\n"
        );

        $loop->run();

        fclose($input);
    }
}