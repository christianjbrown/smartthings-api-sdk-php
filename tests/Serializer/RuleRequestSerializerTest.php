<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\RuleRequest;
use ChristianBrown\SmartThings\Serializer\RuleRequestSerializer;
use ChristianBrown\SmartThings\Serializer\RuleRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RuleRequest::class)]
#[CoversClass(RuleRequestSerializer::class)]
final class RuleRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $actions = [['command' => ['devices' => ['test-device-id'], 'commands' => [['component' => 'main', 'capability' => 'switch', 'command' => 'on']]]]];
        $request = new RuleRequest('Test Rule', $actions);

        $serializer = new RuleRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                RuleRequestSerializerInterface::KEY_NAME => 'Test Rule',
                RuleRequestSerializerInterface::KEY_ACTIONS => $actions,
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

        $serializer = new RuleRequestSerializer();

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
