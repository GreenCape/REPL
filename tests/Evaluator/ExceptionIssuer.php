<?php

namespace GreenCape\REPL\Test\Evaluator;

use GreenCape\REPL\EvaluatorInterface;
use RuntimeException;

/**
 * Class ExceptionIssuer
 *
 * @package GreenCape\REPL\Test
 */
final class ExceptionIssuer implements EvaluatorInterface
{
    /**
     * Set up the evaluator
     *
     * @return void
     */
    public function init(): void
    {
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
        throw new RuntimeException($query, 0, new RuntimeException('Previous exception'));
    }

    /**
     * Tear down the evaluator
     *
     * @return void
     */
    public function exit(): void
    {
    }
}
