<?php

declare(strict_types=1);

namespace Oru\UnicodeTools\CaseFolding;

enum Status: string
{
    case COMMON  = 'C';
    case FULL    = 'F';
    case SIMPLE  = 'S';
    case SPECIAL = 'T';
}
