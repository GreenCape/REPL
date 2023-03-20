<?php

namespace GreenCape\REPL;

interface EvaluatorInterface
{
    public function init(): void;
    public function eval(string $query): string;
    public function exit(): void;
}
