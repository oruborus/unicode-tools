--TEST--
php ./bin/reverse-to-uppercase.php NOT_USED
--ENV--
XDEBUG_MODE=coverage
--FILE--
<?php

declare(strict_types=1);

if (file_exists('./UCD/UnicodeData.txt')) {
    rename('./UCD/UnicodeData.txt', './UCD/UnicodeData');
}

passthru('php ./bin/reverse-to-uppercase.php NOT_USED');

--CLEAN--
<?php

declare(strict_types=1);

if (file_exists('./UCD/UnicodeData')) {
    rename('./UCD/UnicodeData', './UCD/UnicodeData.txt');
}

--EXPECT--
Failed to open './UCD/UnicodeData.txt'
Run `composer run-script get-ucd`.