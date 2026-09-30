<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CommandActionExecutionResult;
use ChristianBrown\SmartThings\Transformer\CommandActionExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommandActionExecutionResultTransformer::class)]
#[CoversClass(CommandActionExecutionResult::class)]
#[CoversClass(ValueReader::class)]
final class CommandActionExecutionResultTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new CommandActionExecutionResultTransformer(new ValueReader()))->transform([]);

        self::assertNull($actual->getResult());
        self::assertNull($actual->getDeviceId());
        self::assertSame([], $actual->getArguments());
    }

    public function testTransformReadsEveryField(): void
    {
        $actual = (new CommandActionExecutionResultTransformer(new ValueReader()))->transform([
            'result' => 'SUCCESS',
            'deviceId' => 'test-device',
            'component' => 'main',
            'capability' => 'switch',
            'command' => 'on',
            'arguments' => [['level' => 80], 'skipped'],
        ]);

        self::assertSame('SUCCESS', $actual->getResult());
        self::assertSame('test-device', $actual->getDeviceId());
        self::assertSame('main', $actual->getComponent());
        self::assertSame('switch', $actual->getCapability());
        self::assertSame('on', $actual->getCommand());
        self::assertSame([['level' => 80]], $actual->getArguments());
    }
}
