<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection;

use ChristianBrown\SmartThings\DependencyInjection\ContainerFactory;
use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(ContainerFactory::class)]
final class ContainerFactoryTest extends TestCase
{
    public function testBuildRunsEveryRegistrarInOrderOnOneContainer(): void
    {
        $calls = [];
        $first = $this->createMock(ServiceRegistrarInterface::class);
        $first->expects(self::once())
            ->method('register')
            ->willReturnCallback(static function (ContainerBuilder $container) use (&$calls): void {
                $calls[] = ['first', $container];
                $container->register('first.service', 'stdClass');
            });
        $second = $this->createMock(ServiceRegistrarInterface::class);
        $second->expects(self::once())
            ->method('register')
            ->willReturnCallback(static function (ContainerBuilder $container) use (&$calls): void {
                $calls[] = ['second', $container];
            });

        $container = (new ContainerFactory([$first, $second]))->build();

        self::assertSame([['first', $container], ['second', $container]], $calls);
        self::assertTrue($container->hasDefinition('first.service'));
    }

    public function testBuildWithNoRegistrarsReturnsAnEmptyContainer(): void
    {
        $container = (new ContainerFactory([]))->build();

        self::assertFalse($container->hasDefinition('first.service'));
    }
}
