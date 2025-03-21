<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use Oru\UnicodeTools\Data\Entry;
use Oru\UnicodeTools\Data\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

use function iterator_to_array;

#[CoversClass(Parser::class)]
#[UsesClass(Entry::class)]
final class ParserTest extends TestCase
{
    #[Test]
    public function createsAnEntryFromAGivenLine(): void
    {
        $parser = new Parser([
            '0041;LATIN CAPITAL LETTER A;Lu;0;L;;;;;N;;;;0061;',
            '',
            '0042;LATIN CAPITAL LETTER B;Lu;0;L;;;;;N;;;;0062;',
        ]);

        $actual = iterator_to_array($parser->parse(), false);

        static::assertEquals(
            [
                new Entry('0041', 'LATIN CAPITAL LETTER A', 'Lu', '0', 'L', '', '', '', '', 'N', '', '', '', '0061', ''),
                new Entry('0042', 'LATIN CAPITAL LETTER B', 'Lu', '0', 'L', '', '', '', '', 'N', '', '', '', '0062', ''),
            ],
            $actual,
        );
    }
}
