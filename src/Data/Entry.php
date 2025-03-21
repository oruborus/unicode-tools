<?php

declare(strict_types=1);

namespace Oru\UnicodeTools\Data;

final readonly class Entry
{
    public function __construct(
        public string $codeValue,
        public string $characterName,
        public string $generalCategory,
        public string $canonicalCombining,
        public string $bidirectionalCategory,
        public string $characterDecomposition,
        public string $decimalDigit,
        public string $digitValue,
        public string $numericValue,
        public string $mirroredNormative,
        public string $unicode1Dot0Name,
        public string $iso10646Comment,
        public string $uppercaseMapping,
        public string $lowercaseMapping,
        public string $titlecaseMapping,
    ) {}
}
