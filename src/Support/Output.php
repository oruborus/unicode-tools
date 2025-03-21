<?php

declare(strict_types=1);

namespace Oru\UnicodeTools\Support;

use RuntimeException;

interface Output
{
    public function putContents(string $contents): void;
}
