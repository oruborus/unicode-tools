<?php

declare(strict_types=1);

namespace Oru\UnicodeTools\CaseFolding;

use Generator;

use function array_map;
use function explode;
use function strcspn;
use function substr;
use function trim;

final class Parser
{
    /** @param iterable<int, string> $lines */
    public function __construct(
        private iterable $lines,
    ) {}

    /** @return Generator<int, Entry> */
    public function parse(): Generator
    {
        foreach ($this->lines as $line) {
            yield from $this->parseEntry($line);
        }
    }

    /** @return Generator<int, Entry> */
    private function parseEntry(string $line): Generator
    {
        $line = trim(substr($line, 0, strcspn($line, '#')));
        if ($line === '') {
            return;
        }

        $rawData = array_map(trim(...), explode(';', $line));

        yield new Entry(...$rawData);
    }
}
