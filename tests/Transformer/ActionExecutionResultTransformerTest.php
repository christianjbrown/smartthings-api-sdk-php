<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ActionExecutionResult;
use ChristianBrown\SmartThings\Model\BehaviorAbnormalExecutionResultInterface;
use ChristianBrown\SmartThings\Model\CommandActionExecutionResultInterface;
use ChristianBrown\SmartThings\Model\IfActionExecutionResultInterface;
use ChristianBrown\SmartThings\Model\LocationActionExecutionResultInterface;
use ChristianBrown\SmartThings\Model\SleepActionExecutionResultInterface;
use ChristianBrown\SmartThings\Transformer\ActionExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\BehaviorAbnormalExecutionResultTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CommandActionExecutionResultTransformerInterface;
use ChristianBrown\SmartThings\Transformer\IfActionExecutionResultTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationActionExecutionResultTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SleepActionExecutionResultTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(ActionExecutionResultTransformer::class)]
#[CoversClass(ActionExecutionResult::class)]
#[CoversClass(ValueReader::class)]
final class ActionExecutionResultTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransformLeavesMissingPartsUnset(): void
    {
        $actual = (new ActionExecutionResultTransformer(new ValueReader(), self::createStub(IfActionExecutionResultTransformerInterface::class), self::createStub(LocationActionExecutionResultTransformerInterface::class), self::createStub(CommandActionExecutionResultTransformerInterface::class), self::createStub(SleepActionExecutionResultTransformerInterface::class), self::createStub(BehaviorAbnormalExecutionResultTransformerInterface::class)))->transform([]);

        self::assertNull($actual->getActionId());
        self::assertNull($actual->getIf());
        self::assertNull($actual->getLocation());
        self::assertSame([], $actual->getCommand());
        self::assertNull($actual->getSleep());
        self::assertNull($actual->getBehavior());
    }

    /**
     * @throws Exception
     */
    public function testTransformReadsEveryKindOfResult(): void
    {
        $if = self::createStub(IfActionExecutionResultInterface::class);
        $location = self::createStub(LocationActionExecutionResultInterface::class);
        $command = self::createStub(CommandActionExecutionResultInterface::class);
        $sleep = self::createStub(SleepActionExecutionResultInterface::class);
        $behavior = self::createStub(BehaviorAbnormalExecutionResultInterface::class);

        $ifTransformer = self::createStub(IfActionExecutionResultTransformerInterface::class);
        $ifTransformer->method('transform')->willReturn($if);
        $locationTransformer = self::createStub(LocationActionExecutionResultTransformerInterface::class);
        $locationTransformer->method('transform')->willReturn($location);
        $commandTransformer = self::createMock(CommandActionExecutionResultTransformerInterface::class);
        $commandTransformer->expects(self::once())->method('transform')->with(['command' => 'on'])->willReturn($command);
        $sleepTransformer = self::createStub(SleepActionExecutionResultTransformerInterface::class);
        $sleepTransformer->method('transform')->willReturn($sleep);
        $behaviorTransformer = self::createStub(BehaviorAbnormalExecutionResultTransformerInterface::class);
        $behaviorTransformer->method('transform')->willReturn($behavior);

        $actual = (new ActionExecutionResultTransformer(new ValueReader(), $ifTransformer, $locationTransformer, $commandTransformer, $sleepTransformer, $behaviorTransformer))->transform([
            'actionId' => 'test-action',
            'if' => ['result' => 'True'],
            'location' => ['result' => 'SUCCESS'],
            'command' => [['command' => 'on'], 'skipped'],
            'sleep' => ['result' => 'SUCCESS'],
            'behavior' => ['result' => 'FAILURE'],
        ]);

        self::assertSame('test-action', $actual->getActionId());
        self::assertSame($if, $actual->getIf());
        self::assertSame($location, $actual->getLocation());
        self::assertSame([$command], $actual->getCommand());
        self::assertSame($sleep, $actual->getSleep());
        self::assertSame($behavior, $actual->getBehavior());
    }
}
