<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequest;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateCapabilityPresentationRequest::class)]
#[CoversClass(CreateCapabilityPresentationRequestSerializer::class)]
final class CreateCapabilityPresentationRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new CreateCapabilityPresentationRequest('test-id');

        $serializer = new CreateCapabilityPresentationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateCapabilityPresentationRequestSerializerInterface::KEY_ID => 'test-id',
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new CreateCapabilityPresentationRequest('test-id'))
            ->setVersion(7)
            ->setDashboard(['test-dashboard-key' => 'test-value'])
            ->setDetailView(['test-detail-view-key' => 'test-value'])
            ->setAutomation(['test-automation-key' => 'test-value'])
            ->setPresentationSettings(['test-presentation-settings-key' => 'test-value']);

        $serializer = new CreateCapabilityPresentationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateCapabilityPresentationRequestSerializerInterface::KEY_ID => 'test-id',
                CreateCapabilityPresentationRequestSerializerInterface::KEY_VERSION => 7,
                CreateCapabilityPresentationRequestSerializerInterface::KEY_DASHBOARD => ['test-dashboard-key' => 'test-value'],
                CreateCapabilityPresentationRequestSerializerInterface::KEY_DETAIL_VIEW => ['test-detail-view-key' => 'test-value'],
                CreateCapabilityPresentationRequestSerializerInterface::KEY_AUTOMATION => ['test-automation-key' => 'test-value'],
                CreateCapabilityPresentationRequestSerializerInterface::KEY_PRESENTATION_SETTINGS => ['test-presentation-settings-key' => 'test-value'],
            ],
            $actual
        );
    }
}
