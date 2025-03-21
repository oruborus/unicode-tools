<?php

declare(strict_types=1);

namespace Oru\UnicodeTools\Support;

use SplFileObject;

final readonly class FileOutput implements Output
{
    public function __construct(
        private SplFileObject $splFileObject,
    ) {}

    public function putContents(string $contents): void
    {
        $this->splFileObject->fwrite($contents);
    }
}
