<?php

namespace GreenCape\REPL;

/**
 * Interface EvaluatorInterface
 *
 * @package GreenCape\REPL
 */
interface EvaluatorInterface
{
    /**
     * Set up the evaluator
     *
     * @return void
     */
    public function init(): void;

    /**
     * Evaluate the query
     *
     * @param  string  $query
     *
     * @return string
     */
    public function eval(string $query): string;

    /**
     * Tear down the evaluator
     *
     * @return void
     */
    public function exit(): void;
}
