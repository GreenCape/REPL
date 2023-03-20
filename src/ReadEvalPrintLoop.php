<?php

namespace GreenCape\REPL;

use Throwable;

/**
 * Class ReadEvalPrintLoop
 *
 * @package GreenCape\REPL
 */
final class ReadEvalPrintLoop
{
    /**
     * ReadEvalPrintLoop constructor.
     *
     * @param  \GreenCape\REPL\EvaluatorInterface  $evaluator  The evaluator to use
     * @param  resource                            $input      An optional input stream, defaults to STDIN
     */
    public function __construct(
        private readonly EvaluatorInterface $evaluator,
        private $input = null,
    ) {
        if ($this->input === null) {
            $this->input = fopen('php://stdin', 'r');
        }

        rewind($this->input);
    }

    /**
     * Run the loop
     *
     * The loop reads a query from the input stream, evaluates it and prints the result.
     * The loop is terminated by the query 'exit'.
     */
    public function run(): void
    {
        $this->evaluator->init();

        while (true) {
            $query = '';
            $input = $this->readline('> ');

            if ($input === 'exit') {
                break;
            }

            while (str_ends_with($input, '\\')) {
                $query .= substr($input, 0, -1) . "\n";
                $input = $this->readline('>> ');
            }

            $query .= $input;

            try {
                echo $this->evaluator->eval($query) . PHP_EOL;
            } catch (Throwable $e) {
                $this->printException($e);
            }
        }

        $this->evaluator->exit();

        echo 'Bye!' . PHP_EOL;
    }

    /**
     * Print an exception
     *
     * @param  \Throwable  $e  The exception to print
     *
     * @return void
     */
    private function printException(Throwable $e): void
    {
        $i = 0;
        echo 'Error:' . PHP_EOL;

        do {
            echo ++$i . '. ' . $e->getMessage() . PHP_EOL;
            $e = $e->getPrevious();
        } while ($e);
    }

    /**
     * Read a line from the input stream
     *
     * @param  string  $prompt  An optional prompt
     *
     * @return string
     */
    private function readline(string $prompt = ''): string
    {
        echo $prompt;

        return rtrim(fgets($this->input), "\r\n");
    }
}
