<?php

namespace GreenCape\REPL\Test\Evaluator;

use GreenCape\REPL\EvaluatorInterface;

/**
 * Class Mocker
 *
 * @package GreenCape\REPL\Test
 */
final class Mocker implements EvaluatorInterface
{
    public array $history = [];

    /**
     * Set up the evaluator
     *
     * @return void
     */
    public function init(): void
    {
        $this->history[] = 'init';
    }

    /**
     * Evaluate the query
     *
     * @param  string  $query
     *
     * @return string
     */
    public function eval(string $query): string
    {
        $this->history[] = $query;

        return "Query: $query";
    }

    /**
     * Tear down the evaluator
     *
     * @return void
     */
    public function exit(): void
    {
        $this->history[] = 'exit';
    }
}
