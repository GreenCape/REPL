<?php

namespace GreenCape\REPL\Test\Evaluator;

use GreenCape\REPL\EvaluatorInterface;

final class ExceptionIssuer implements EvaluatorInterface
{
    public function init(): void
    {
    }

    public function eval(string $query): string
    {
        throw new \RuntimeException($query, 0, new \RuntimeException('Previous exception'));
    }

    public function exit(): void
    {
    }
}
