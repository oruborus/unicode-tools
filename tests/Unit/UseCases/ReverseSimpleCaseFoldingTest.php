<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases;

use Oru\UnicodeTools\CaseFolding\Entry;
use Oru\UnicodeTools\Support\Output;
use Oru\UnicodeTools\UseCases\ReverseSimpleCaseFolding;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ReverseSimpleCaseFolding::class)]
#[UsesClass(Entry::class)]
final class ReverseSimpleCaseFoldingTest extends TestCase
{
    #[Test]
    public function writesDefaultMatchExpressionToOutput(): void
    {
        $expected = <<<'EXPECTED'
        <?php

        match ($codePoint) {
            default => [$codePoint, \mb_ord(\mb_convert_case(\mb_chr($codePoint, 'UTF-8'), \MB_CASE_FOLD_SIMPLE, 'UTF-8'), 'UTF-8')],
        };

        EXPECTED;

        $outputMock = $this->createMock(Output::class);
        $outputMock
            ->expects($this->once())
            ->method('putContents')
            ->with(static::identicalTo($expected));

        new ReverseSimpleCaseFolding([], $outputMock)->create();
    }

    #[Test]
    public function containsMatchArmForEntry(): void
    {
        $expected = <<<'EXPECTED'
            0x0442 => [$codePoint, 0x0422, 0x1C84, 0x1C85],
            0x044A => [$codePoint, 0x042A, 0x1C86],
            default => [$codePoint, \mb_ord(\mb_convert_case(\mb_chr($codePoint, 'UTF-8'), \MB_CASE_FOLD_SIMPLE, 'UTF-8'), 'UTF-8')],
        EXPECTED;

        $outputMock = $this->createMock(Output::class);
        $outputMock
            ->expects($this->once())
            ->method('putContents')
            ->with(static::stringContains($expected));

        new ReverseSimpleCaseFolding([
            new Entry('042A', 'C', '044A'),
            new Entry('1C86', 'C', '044A'),
            new Entry('0422', 'C', '0442'),
            new Entry('1C84', 'C', '0442'),
            new Entry('1C85', 'C', '0442'),
        ], $outputMock)->create();
    }

    #[Test]
    public function skipsFullOrSpecialMappings(): void
    {
        $outputMock = $this->createMock(Output::class);
        $outputMock
            ->expects($this->once())
            ->method('putContents')
            ->with(
                static::logicalNot(static::logicalOr(
                    static::stringContains('0x1000 => [$codePoint, 0x0001, 0x0002],'),
                    static::stringContains('0x3000 => [$codePoint, 0x0003, 0x0004],'),
                ))
            );

        new ReverseSimpleCaseFolding([
            new Entry('0001', 'F', '1000'),
            new Entry('0002', 'F', '1000'),
            new Entry('0003', 'T', '3000'),
            new Entry('0004', 'T', '3000'),
        ], $outputMock)->create();
    }

    #[Test]
    public function skipsMappingsForJustOneCodePoint(): void
    {
        $expected = '0x0046 => [$codePoint, 0x0066],';

        $outputMock = $this->createMock(Output::class);
        $outputMock
            ->expects($this->once())
            ->method('putContents')
            ->with(static::logicalNot(static::stringContains($expected)));

        new ReverseSimpleCaseFolding([
            new Entry('0066', 'C', '0046'),
        ], $outputMock)->create();
    }
}
