<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Exception;

use ChristianBrown\SmartThings\Exception\ExceptionInterface;
use ChristianBrown\SmartThings\Exception\UnregisteredTypeException;
use ChristianBrown\SmartThings\Exception\UnregisteredTypeExceptionInterface;
use LogicException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function class_implements;
use function class_parents;

#[CoversClass(UnregisteredTypeException::class)]
final class UnregisteredTypeExceptionTest extends TestCase
{
    public function test(): void
    {
        $exception = new UnregisteredTypeException('test-message');
        $interfaces = class_implements($exception);
        $parents = class_parents($exception);

        self::assertArrayHasKey(UnregisteredTypeExceptionInterface::class, $interfaces);
        self::assertArrayHasKey(ExceptionInterface::class, $interfaces);
        self::assertArrayHasKey(LogicException::class, $parents);
        self::assertSame('test-message', $exception->getMessage());
    }
}
