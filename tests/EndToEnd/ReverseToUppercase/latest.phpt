--TEST--
php ./bin/reverse-to-uppercase.php TEST_OUT.php
--SKIPIF--
<?php

declare(strict_types=1);

if (!file_exists('./UCD/UnicodeData.txt')) {
    echo 'skip: UnicodeData.txt is required' . PHP_EOL;
    exit;
}
--ENV--
XDEBUG_MODE=coverage
--FILE--
<?php

declare(strict_types=1);

exec('php ./bin/reverse-to-uppercase.php ' . __DIR__ . '/TEST_OUT.php');

echo file_get_contents(__DIR__ . '/TEST_OUT.php');

--CLEAN--
<?php

declare(strict_types=1);


unlink(__DIR__ . '/TEST_OUT.php');
--EXPECT--
<?php

match ($codePoint) {
    0x0049 => [$codePoint, 0x0069, 0x0131],
    0x0053 => [$codePoint, 0x0073, 0x017F],
    0x01C4 => [$codePoint, 0x01C5, 0x01C6],
    0x01C7 => [$codePoint, 0x01C8, 0x01C9],
    0x01CA => [$codePoint, 0x01CB, 0x01CC],
    0x01F1 => [$codePoint, 0x01F2, 0x01F3],
    0x0392 => [$codePoint, 0x03B2, 0x03D0],
    0x0395 => [$codePoint, 0x03B5, 0x03F5],
    0x0398 => [$codePoint, 0x03B8, 0x03D1],
    0x0399 => [$codePoint, 0x0345, 0x03B9, 0x1FBE],
    0x039A => [$codePoint, 0x03BA, 0x03F0],
    0x039C => [$codePoint, 0x00B5, 0x03BC],
    0x03A0 => [$codePoint, 0x03C0, 0x03D6],
    0x03A1 => [$codePoint, 0x03C1, 0x03F1],
    0x03A3 => [$codePoint, 0x03C2, 0x03C3],
    0x03A6 => [$codePoint, 0x03C6, 0x03D5],
    0x0412 => [$codePoint, 0x0432, 0x1C80],
    0x0414 => [$codePoint, 0x0434, 0x1C81],
    0x041E => [$codePoint, 0x043E, 0x1C82],
    0x0421 => [$codePoint, 0x0441, 0x1C83],
    0x0422 => [$codePoint, 0x0442, 0x1C84, 0x1C85],
    0x042A => [$codePoint, 0x044A, 0x1C86],
    0x0462 => [$codePoint, 0x0463, 0x1C87],
    0x1E60 => [$codePoint, 0x1E61, 0x1E9B],
    0xA64A => [$codePoint, 0x1C88, 0xA64B],
    default => [$codePoint, \mb_ord(\mb_convert_case(\mb_chr($codePoint, 'UTF-8'), \MB_CASE_LOWER, 'UTF-8'), 'UTF-8')],
};
