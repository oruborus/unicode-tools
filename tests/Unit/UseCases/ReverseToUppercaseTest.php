<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases;

use Oru\UnicodeTools\Data\Entry;
use Oru\UnicodeTools\Support\Output;
use Oru\UnicodeTools\UseCases\ReverseToUppercase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ReverseToUppercase::class)]
#[UsesClass(Entry::class)]
final class ReverseToUppercaseTest extends TestCase
{
    #[Test]
    public function writesDefaultMatchExpressionToOutput(): void
    {
        $expected = <<<'EXPECTED'
        <?php

        match ($codePoint) {
            default => [$codePoint, \mb_ord(\mb_convert_case(\mb_chr($codePoint, 'UTF-8'), \MB_CASE_LOWER, 'UTF-8'), 'UTF-8')],
        };

        EXPECTED;

        $outputMock = $this->createMock(Output::class);
        $outputMock
            ->expects($this->once())
            ->method('putContents')
            ->with(static::identicalTo($expected));

        new ReverseToUppercase([], $outputMock)->create();
    }

    #[Test]
    public function containsMatchArmForEntry(): void
    {
        $expected = <<<'EXPECTED'
            0x0422 => [$codePoint, 0x0442, 0x1C84, 0x1C85],
            0xA64A => [$codePoint, 0x1C88, 0xA64B],
            default => [$codePoint, \mb_ord(\mb_convert_case(\mb_chr($codePoint, 'UTF-8'), \MB_CASE_LOWER, 'UTF-8'), 'UTF-8')],
        EXPECTED;

        $outputMock = $this->createMock(Output::class);
        $outputMock
            ->expects($this->once())
            ->method('putContents')
            ->with(static::stringContains($expected));

        new ReverseToUppercase([
            new Entry('1C88', 'CYRILLIC SMALL LETTER UNBLENDED UK', 'Ll', '0', 'L', '', '', '', '', 'N', '', '', 'A64A', '', 'A64A'),
            new Entry('A64B', 'CYRILLIC SMALL LETTER MONOGRAPH UK', 'Ll', '0', 'L', '', '', '', '', 'N', '', '', 'A64A', '', 'A64A'),
            new Entry('0442', 'CYRILLIC SMALL LETTER TE', 'Tl', '0', 'L', '', '', '', '', 'N', '', '', '0422', '', '0422'),
            new Entry('1C84', 'CYRILLIC SMALL LETTER TALL TE', 'Tl', '0', 'L', '', '', '', '', 'N', '', '', '0422', '', '0422'),
            new Entry('1C85', 'CYRILLIC SMALL LETTER THREE-LEGGED TE', 'Tl', '0', 'L', '', '', '', 'N', '', '', '', '0422', '', '0422'),
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

        new ReverseToUppercase([
            new Entry('0066', 'LATIN SMALL LETTER F', 'Ll', '0', 'L', '', '', '', '', 'N', '', '', '0046', '', '0046'),
        ], $outputMock)->create();
    }
}
