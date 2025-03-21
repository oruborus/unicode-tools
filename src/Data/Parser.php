<?php

declare(strict_types=1);

namespace Oru\UnicodeTools\Data;

use Generator;

use function explode;

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
        if ($line === '') {
            return;
        }

        $rawData = explode(';', $line);

        yield new Entry(...$rawData);
    }
}
