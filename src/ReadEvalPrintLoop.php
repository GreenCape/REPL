<?php

namespace GreenCape\REPL;

use Throwable;

final class ReadEvalPrintLoop
{
    /**
     * @param  \GreenCape\REPL\EvaluatorInterface  $evaluator
     * @param  resource                            $input
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
     * @param  \Throwable  $e
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

    private function readline(string $prompt = ''): string
    {
        echo $prompt;

        return rtrim(fgets($this->input), "\r\n");
    }
}
