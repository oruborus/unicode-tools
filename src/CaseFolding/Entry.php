<?php

declare(strict_types=1);

namespace Oru\UnicodeTools\CaseFolding;

use function str_contains;

final readonly class Entry
{
    public Status $status;

    public bool $mapsToMultipleCodePoints;

    public function __construct(
        public string $code,
        string $status,
        public string $mapping,
    ) {
        $this->status = Status::from($status);
        $this->mapsToMultipleCodePoints = str_contains($mapping, ' ');
    }
}
