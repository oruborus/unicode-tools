--TEST--
php ./bin/reverse-simple-case-folding.php
--ENV--
XDEBUG_MODE=coverage
--FILE--
<?php

declare(strict_types=1);

passthru('php ./bin/reverse-simple-case-folding.php');

--EXPECT--
No output path declared!
Usage `php ./bin/reverse-simple-case-folding.php <output path>`