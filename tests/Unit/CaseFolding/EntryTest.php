<?php

declare(strict_types=1);

namespace Tests\Unit\CaseFolding;

use Generator;
use Oru\UnicodeTools\CaseFolding\Entry;
use Oru\UnicodeTools\CaseFolding\Status;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Entry::class)]
final class EntryTest extends TestCase
{
    #[Test]
    #[DoesNotPerformAssertions]
    public function getsCreated(): void
    {
        $_ = new Entry(code: '0041', status: 'C', mapping: '0061');
    }

    #[Test]
    #[DataProvider('provideStatus')]
    public function communicatesCorrectEntryStatus(string $input, Status $expected): void
    {
        $entry = new Entry(code: '0041', status: $input, mapping: '0061');

        $actual = $entry->status;

        static::assertSame($expected, $actual);
    }

    /** @return Generator<string, array{string, Status}> */
    public static function provideStatus(): Generator
    {
        foreach (Status::cases() as $case) {
            yield $case->name => [$case->value, $case];
        }
    }

    #[Test]
    #[DataProvider('provideRawCaseFoldingEntry')]
    public function communicatesThatEntryMapsToMultipleCodePoints(
        string $code,
        string $status,
        string $mapping,
        bool $expected,
    ): void {
        $entry = new Entry(
            code: $code,
            status: $status,
            mapping: $mapping,
        );

        $actual = $entry->mapsToMultipleCodePoints;

        static::assertSame($expected, $actual);
    }

    /** @return Generator<string, array{string, string, string, bool}> */
    public static function provideRawCaseFoldingEntry(): Generator
    {
        yield 'LATIN SMALL LETTER SHARP S' => ['00DF', 'F', '0073 0073', true];
        yield 'LATIN CAPITAL LETTER A WITH MACRON' => ['0100', 'C', '0101', false];
    }
}
