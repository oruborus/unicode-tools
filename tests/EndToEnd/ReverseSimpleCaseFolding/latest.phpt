--TEST--
php ./bin/reverse-simple-case-folding.php TEST_OUT.php
--SKIPIF--
<?php

declare(strict_types=1);

if (!file_exists('./UCD/CaseFolding.txt')) {
    echo 'skip: CaseFolding.txt is required' . PHP_EOL;
    exit;
}
--ENV--
XDEBUG_MODE=coverage
--FILE--
<?php

declare(strict_types=1);

exec('php ./bin/reverse-simple-case-folding.php ' . __DIR__ . '/TEST_OUT.php');

echo file_get_contents(__DIR__ . '/TEST_OUT.php');

--CLEAN--
<?php

unlink(__DIR__ . '/TEST_OUT.php');
--EXPECT--
<?php

match ($codePoint) {
    0x006B => [$codePoint, 0x004B, 0x212A],
    0x0073 => [$codePoint, 0x0053, 0x017F],
    0x00E5 => [$codePoint, 0x00C5, 0x212B],
    0x01C6 => [$codePoint, 0x01C4, 0x01C5],
    0x01C9 => [$codePoint, 0x01C7, 0x01C8],
    0x01CC => [$codePoint, 0x01CA, 0x01CB],
    0x01F3 => [$codePoint, 0x01F1, 0x01F2],
    0x03B2 => [$codePoint, 0x0392, 0x03D0],
    0x03B5 => [$codePoint, 0x0395, 0x03F5],
    0x03B8 => [$codePoint, 0x0398, 0x03D1, 0x03F4],
    0x03B9 => [$codePoint, 0x0345, 0x0399, 0x1FBE],
    0x03BA => [$codePoint, 0x039A, 0x03F0],
    0x03BC => [$codePoint, 0x00B5, 0x039C],
    0x03C0 => [$codePoint, 0x03A0, 0x03D6],
    0x03C1 => [$codePoint, 0x03A1, 0x03F1],
    0x03C3 => [$codePoint, 0x03A3, 0x03C2],
    0x03C6 => [$codePoint, 0x03A6, 0x03D5],
    0x03C9 => [$codePoint, 0x03A9, 0x2126],
    0x0432 => [$codePoint, 0x0412, 0x1C80],
    0x0434 => [$codePoint, 0x0414, 0x1C81],
    0x043E => [$codePoint, 0x041E, 0x1C82],
    0x0441 => [$codePoint, 0x0421, 0x1C83],
    0x0442 => [$codePoint, 0x0422, 0x1C84, 0x1C85],
    0x044A => [$codePoint, 0x042A, 0x1C86],
    0x0463 => [$codePoint, 0x0462, 0x1C87],
    0x1E61 => [$codePoint, 0x1E60, 0x1E9B],
    0xA64B => [$codePoint, 0x1C88, 0xA64A],
    default => [$codePoint, \mb_ord(\mb_convert_case(\mb_chr($codePoint, 'UTF-8'), \MB_CASE_FOLD_SIMPLE, 'UTF-8'), 'UTF-8')],
};
