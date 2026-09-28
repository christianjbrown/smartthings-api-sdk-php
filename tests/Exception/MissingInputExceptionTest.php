<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Exception;

use ChristianBrown\SmartThings\Exception\ExceptionInterface;
use ChristianBrown\SmartThings\Exception\MissingInputException;
use ChristianBrown\SmartThings\Exception\MissingInputExceptionInterface;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function class_implements;
use function class_parents;

#[CoversClass(MissingInputException::class)]
final class MissingInputExceptionTest extends TestCase
{
    public function test(): void
    {
        $exception = new MissingInputException('test-message');
        $interfaces = class_implements($exception);
        $parents = class_parents($exception);

        self::assertArrayHasKey(MissingInputExceptionInterface::class, $interfaces);
        self::assertArrayHasKey(ExceptionInterface::class, $interfaces);
        self::assertArrayHasKey(InvalidArgumentException::class, $parents);
        self::assertSame('test-message', $exception->getMessage());
    }
}
