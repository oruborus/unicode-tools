<?php

declare(strict_types=1);

namespace Tests\Unit\CaseFolding;

use Oru\UnicodeTools\CaseFolding\Entry;
use Oru\UnicodeTools\CaseFolding\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

use function iterator_to_array;

use const PHP_EOL;

#[CoversClass(Parser::class)]
#[UsesClass(Entry::class)]
final class ParserTest extends TestCase
{
    #[Test]
    public function createsAnEntryFromAGivenLine(): void
    {
        $parser = new Parser(['0041; C; 0061']);

        $actual = iterator_to_array($parser->parse(), false);

        static::assertEquals(
            [new Entry('0041', 'C', '0061')],
            $actual,
        );
    }

    #[Test]
    public function ignoresEmptyLines(): void
    {
        $parser = new Parser(['0041; C; 0061', PHP_EOL, '0042; C; 0062']);

        $actual = iterator_to_array($parser->parse(), false);

        static::assertEquals(
            [
                new Entry('0041', 'C', '0061'),
                new Entry('0042', 'C', '0062'),
            ],
            $actual,
        );
    }

    #[Test]
    public function removesComments(): void
    {
        $parser = new Parser(['0041; C; 0061   # Comment']);

        $actual = iterator_to_array($parser->parse(), false);

        static::assertEquals(
            [new Entry('0041', 'C', '0061')],
            $actual,
        );
    }
}
