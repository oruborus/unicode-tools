<?php

declare(strict_types=1);

use Oru\UnicodeTools\CaseFolding\Parser;
use Oru\UnicodeTools\Support\FileOutput;
use Oru\UnicodeTools\UseCases\ReverseSimpleCaseFolding;

require './vendor/autoload.php';

$outputFilePath = $argv[1] ?? false;
if ($outputFilePath === false) {
    echo <<<EOF

    No output path declared!
    Usage `php ./bin/reverse-simple-case-folding.php <output path>`


    EOF;
    exit;
}

try {
    /** @var iterable<int, string>&SplFileObject $lines */
    $lines = new SplFileObject('./UCD/CaseFolding.txt');
} catch (RuntimeException | LogicException) {
    echo <<<EOF
    
    Failed to open './UCD/CaseFolding.txt'
    Run `composer run-script get-ucd`.
    
    
    EOF;
    exit;
}

try {
    $outputFile = new SplFileObject($outputFilePath, 'w');
} catch (RuntimeException | LogicException) {
    echo <<<EOF
    
    Failed to open '$outputFilePath'
    
    
    EOF;
    exit;
}

new ReverseSimpleCaseFolding(
    input: new Parser($lines)->parse(),
    output: new FileOutput($outputFile),
)->create();
