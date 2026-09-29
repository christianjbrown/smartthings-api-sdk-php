<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequence;
use ChristianBrown\SmartThings\Model\RuleRequest;
use ChristianBrown\SmartThings\Serializer\ActionSerializerInterface;
use ChristianBrown\SmartThings\Serializer\RuleRequestSerializer;
use ChristianBrown\SmartThings\Serializer\RuleRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ActionSequence::class)]
#[CoversClass(RuleRequest::class)]
#[CoversClass(RuleRequestSerializer::class)]
final class RuleRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $actions = [['command' => ['devices' => ['test-device-id'], 'commands' => [['component' => 'main', 'capability' => 'switch', 'command' => 'on']]]]];
        $request = new RuleRequest('Test Rule', $actions);

        $serializer = new RuleRequestSerializer(self::createStub(ActionSerializerInterface::class));

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                RuleRequestSerializerInterface::KEY_NAME => 'Test Rule',
                RuleRequestSerializerInterface::KEY_ACTIONS => $actions,
            ],
            $actual
        );
    }

    public function testSerializeTypedActionsAndSequence(): void
    {
        $action = self::createStub(ActionInterface::class);

        $actionSerializer = self::createMock(ActionSerializerInterface::class);
        $actionSerializer->expects(self::once())->method('serialize')
            ->with($action)
            ->willReturn(['test-serialized-action']);

        $rawAction = ['sleep' => ['duration' => ['value' => 5, 'unit' => 'Minute']]];
        $request = (new RuleRequest('Test Rule', [$action, $rawAction]))
            ->setSequence('Serial')
            ->setActionSequence((new ActionSequence())->setActions('Parallel'));

        $serializer = new RuleRequestSerializer($actionSerializer);

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                RuleRequestSerializerInterface::KEY_NAME => 'Test Rule',
                RuleRequestSerializerInterface::KEY_ACTIONS => [['test-serialized-action'], $rawAction],
                RuleRequestSerializerInterface::KEY_SEQUENCE => [RuleRequestSerializerInterface::KEY_ACTIONS => 'Parallel'],
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $actions = [['sleep' => ['duration' => ['value' => 5, 'unit' => 'Minute']]]];
        $request = (new RuleRequest('Test Rule', $actions))
            ->setSequence('Parallel')
            ->setTimeZoneId('Europe/London');

        $serializer = new RuleRequestSerializer(self::createStub(ActionSerializerInterface::class));

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                RuleRequestSerializerInterface::KEY_NAME => 'Test Rule',
                RuleRequestSerializerInterface::KEY_ACTIONS => $actions,
                RuleRequestSerializerInterface::KEY_SEQUENCE => 'Parallel',
                RuleRequestSerializerInterface::KEY_TIME_ZONE_ID => 'Europe/London',
            ],
            $actual
        );
    }
}
