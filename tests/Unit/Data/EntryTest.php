<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use Oru\UnicodeTools\Data\Entry;
use PHPUnit\Framework\Attributes\CoversClass;
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
        $_ = new Entry(
            codeValue: '217F',
            characterName: 'SMALL ROMAN NUMERAL ONE THOUSAND',
            generalCategory: 'Nl',
            canonicalCombining: '0',
            bidirectionalCategory: 'L',
            characterDecomposition: '<compat> 006D',
            decimalDigit: '',
            digitValue: '',
            numericValue: '1000',
            mirroredNormative: 'N',
            unicode1Dot0Name: '',
            iso10646Comment: '',
            uppercaseMapping: '216F',
            lowercaseMapping: '',
            titlecaseMapping: '216F',
        );
    }
}
