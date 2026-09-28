<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Exception;

use ChristianBrown\SmartThings\Exception\ExceptionInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseExceptionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function class_implements;
use function class_parents;

#[CoversClass(UnexpectedResponseException::class)]
final class UnexpectedResponseExceptionTest extends TestCase
{
    public function test(): void
    {
        $exception = new UnexpectedResponseException('test-message');
        $interfaces = class_implements($exception);
        $parents = class_parents($exception);

        self::assertArrayHasKey(UnexpectedResponseExceptionInterface::class, $interfaces);
        self::assertArrayHasKey(ExceptionInterface::class, $interfaces);
        self::assertArrayHasKey(RuntimeException::class, $parents);
        self::assertSame('test-message', $exception->getMessage());
    }
}
