--TEST--
php ./bin/reverse-to-uppercase.php
--ENV--
XDEBUG_MODE=coverage
--FILE--
<?php

declare(strict_types=1);

passthru('php ./bin/reverse-to-uppercase.php');

--EXPECT--
No output path declared!
Usage `php ./bin/reverse-to-uppercase.php <output path>`