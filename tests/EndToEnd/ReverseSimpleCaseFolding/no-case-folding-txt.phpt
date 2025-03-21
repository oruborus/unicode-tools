--TEST--
php ./bin/reverse-simple-case-folding.php NOT_USED
--ENV--
XDEBUG_MODE=coverage
--FILE--
<?php

declare(strict_types=1);

if (file_exists('./UCD/CaseFolding.txt')) {
    rename('./UCD/CaseFolding.txt', './UCD/CaseFolding');
}

passthru('php ./bin/reverse-simple-case-folding.php NOT_USED');

--CLEAN--
<?php

declare(strict_types=1);

if (file_exists('./UCD/CaseFolding')) {
    rename('./UCD/CaseFolding', './UCD/CaseFolding.txt');
}

--EXPECT--
Failed to open './UCD/CaseFolding.txt'
Run `composer run-script get-ucd`.