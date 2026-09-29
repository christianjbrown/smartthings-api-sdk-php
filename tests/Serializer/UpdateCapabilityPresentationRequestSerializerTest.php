<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\UpdateCapabilityPresentationRequest;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityPresentationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityPresentationRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UpdateCapabilityPresentationRequest::class)]
#[CoversClass(UpdateCapabilityPresentationRequestSerializer::class)]
final class UpdateCapabilityPresentationRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new UpdateCapabilityPresentationRequest();

        $serializer = new UpdateCapabilityPresentationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new UpdateCapabilityPresentationRequest())
            ->setDashboard(['test-dashboard-key' => 'test-value'])
            ->setDetailView(['test-detail-view-key' => 'test-value'])
            ->setAutomation(['test-automation-key' => 'test-value'])
            ->setPresentationSettings(['test-presentation-settings-key' => 'test-value']);

        $serializer = new UpdateCapabilityPresentationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateCapabilityPresentationRequestSerializerInterface::KEY_DASHBOARD => ['test-dashboard-key' => 'test-value'],
                UpdateCapabilityPresentationRequestSerializerInterface::KEY_DETAIL_VIEW => ['test-detail-view-key' => 'test-value'],
                UpdateCapabilityPresentationRequestSerializerInterface::KEY_AUTOMATION => ['test-automation-key' => 'test-value'],
                UpdateCapabilityPresentationRequestSerializerInterface::KEY_PRESENTATION_SETTINGS => ['test-presentation-settings-key' => 'test-value'],
            ],
            $actual
        );
    }
}
