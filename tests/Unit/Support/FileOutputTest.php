<?php

declare(strict_types=1);

namespace Tests\Unit\Support;

use Oru\UnicodeTools\Support\FileOutput;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SplFileObject;

#[CoversClass(FileOutput::class)]
final class FileOutputTest extends TestCase
{
    #[Test]
    public function writesContentsIntoFileObject(): void
    {
        $content = <<<CONTENT
        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
        labore et dolore magna aliquyam erat, sed diam voluptua.
        At vero eos et accusam et justo duo dolores et ea rebum.
        Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
        CONTENT;

        $splFileObjectMock = $this->getMockBuilder(SplFileObject::class)
            ->setConstructorArgs(['php://memory'])
            ->getMock();
        $splFileObjectMock
            ->expects($this->once())
            ->method('fwrite')
            ->with(
                static::identicalTo($content),
                static::identicalTo(0),
            );

        $output = new FileOutput($splFileObjectMock);

        $output->putContents($content);
    }
}
