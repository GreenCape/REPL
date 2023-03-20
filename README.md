# Read-Eval-Print Loop (REPL) for PHP

GreenCape REPL is a simple Read-Eval-Print Loop (REPL) written in PHP.
It can be combined with arbitrary evaluators for the Eval step.

## Installation

```bash
composer require greencape/repl
```

## Usage

Create an Evaluator implementing the `GreenCape\REPL\EvaluatorInterface` and pass it to the REPL:

```php
use GreenCape\REPL\EvaluatorInterface;
use GreenCape\REPL\ReadEvalPrintLoop;

class MyEvaluator implements EvaluatorInterface
{
    public function init(): void {}
    public function exit(): void {}
    public function eval(string $input): string
    {
        // Handle the input and return the result
        return $result;
    }
}

$evaluator = new MyEvaluator();
$repl      = new ReadEvalPrintLoop($evaluator);

$repl->run();
```

With `init()` and `exit()` you can implement a setup and teardown for the REPL.

The loop will read your input after a '> ' prompt' and send it to the `eval()` method of the Evaluator.
The result will be printed to the console.
You can enter multi line input by ending each line with a backslash.
Continuation lines are indicated by a '>> ' prompt.

To terminate the loop, enter `exit`.
