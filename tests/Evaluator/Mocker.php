<?php

namespace GreenCape\REPL\Test\Evaluator;

use GreenCape\REPL\EvaluatorInterface;

final class Mocker implements EvaluatorInterface
{
    public array $history = [];

    public function init(): void
    {
        $this->history[] = 'init';
    }

    public function eval(string $query): string
    {
        $this->history[] = $query;

        return "Query: $query";
    }

    public function exit(): void
    {
        $this->history[] = 'exit';
    }
}
