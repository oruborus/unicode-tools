--TEST--
php ./bin/reverse-to-uppercase.php ./bin
--ENV--
XDEBUG_MODE=coverage
--FILE--
<?php

declare(strict_types=1);

passthru('php ./bin/reverse-to-uppercase.php ./bin');

--EXPECT--
Failed to open './bin'