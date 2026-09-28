<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CreateInstalledAppEventsRequest;
use ChristianBrown\SmartThings\Model\SmartAppDashboardCardEventRequest;
use ChristianBrown\SmartThings\Model\SmartAppEventRequest;
use ChristianBrown\SmartThings\Serializer\CreateInstalledAppEventsRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateInstalledAppEventsRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateInstalledAppEventsRequest::class)]
#[CoversClass(SmartAppDashboardCardEventRequest::class)]
#[CoversClass(SmartAppEventRequest::class)]
#[CoversClass(CreateInstalledAppEventsRequestSerializer::class)]
final class CreateInstalledAppEventsRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new CreateInstalledAppEventsRequest();

        $serializer = new CreateInstalledAppEventsRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new CreateInstalledAppEventsRequest())
            ->setSmartAppEvents([(new SmartAppEventRequest('test-name'))
                ->setAttributes(['test-attributes-key' => 'test-value'])])
            ->setSmartAppDashboardCardEvents([new SmartAppDashboardCardEventRequest('test-card-id', 'test-lifecycle')]);

        $serializer = new CreateInstalledAppEventsRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateInstalledAppEventsRequestSerializerInterface::KEY_SMART_APP_EVENTS => [[
                    CreateInstalledAppEventsRequestSerializerInterface::KEY_NAME => 'test-name',
                    CreateInstalledAppEventsRequestSerializerInterface::KEY_ATTRIBUTES => ['test-attributes-key' => 'test-value'],
                ]],
                CreateInstalledAppEventsRequestSerializerInterface::KEY_SMART_APP_DASHBOARD_CARD_EVENTS => [[
                    CreateInstalledAppEventsRequestSerializerInterface::KEY_CARD_ID => 'test-card-id',
                    CreateInstalledAppEventsRequestSerializerInterface::KEY_LIFECYCLE => 'test-lifecycle',
                ]],
            ],
            $actual
        );
    }

    public function testSerializeWithNestedOptionalsUnset(): void
    {
        $request = (new CreateInstalledAppEventsRequest())
            ->setSmartAppEvents([new SmartAppEventRequest('test-name')])
            ->setSmartAppDashboardCardEvents([new SmartAppDashboardCardEventRequest('test-card-id', 'test-lifecycle')]);

        $serializer = new CreateInstalledAppEventsRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateInstalledAppEventsRequestSerializerInterface::KEY_SMART_APP_EVENTS => [[
                    CreateInstalledAppEventsRequestSerializerInterface::KEY_NAME => 'test-name',
                ]],
                CreateInstalledAppEventsRequestSerializerInterface::KEY_SMART_APP_DASHBOARD_CARD_EVENTS => [[
                    CreateInstalledAppEventsRequestSerializerInterface::KEY_CARD_ID => 'test-card-id',
                    CreateInstalledAppEventsRequestSerializerInterface::KEY_LIFECYCLE => 'test-lifecycle',
                ]],
            ],
            $actual
        );
    }
}
