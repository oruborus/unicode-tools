--TEST--
php ./bin/reverse-simple-case-folding.php ./bin
--ENV--
XDEBUG_MODE=coverage
--FILE--
<?php

declare(strict_types=1);

passthru('php ./bin/reverse-simple-case-folding.php ./bin');

--EXPECT--
Failed to open './bin'