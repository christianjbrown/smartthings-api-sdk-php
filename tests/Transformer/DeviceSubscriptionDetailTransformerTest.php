<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceSubscriptionDetail;
use ChristianBrown\SmartThings\Transformer\DeviceSubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceSubscriptionDetailTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceSubscriptionDetail::class)]
#[CoversClass(DeviceSubscriptionDetailTransformer::class)]
final class DeviceSubscriptionDetailTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceSubscriptionDetailTransformerInterface::KEY_DEVICE_ID => 'test-device-id',
            DeviceSubscriptionDetailTransformerInterface::KEY_COMPONENT_ID => 'test-component-id',
            DeviceSubscriptionDetailTransformerInterface::KEY_CAPABILITY => 'test-capability',
            DeviceSubscriptionDetailTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
            DeviceSubscriptionDetailTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
            DeviceSubscriptionDetailTransformerInterface::KEY_STATE_CHANGE_ONLY => true,
            DeviceSubscriptionDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
            DeviceSubscriptionDetailTransformerInterface::KEY_MODES => ['test-modes-1', 'test-modes-2'],
        ];

        $transformer = new DeviceSubscriptionDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-device-id', $actual->getDeviceId());
        self::assertSame('test-component-id', $actual->getComponentId());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame('test-attribute', $actual->getAttribute());
        self::assertSame(['test-value-key' => 'test-value'], $actual->getValue());
        self::assertTrue($actual->getStateChangeOnly());
        self::assertSame('test-subscription-name', $actual->getSubscriptionName());
        self::assertSame(['test-modes-1', 'test-modes-2'], $actual->getModes());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DeviceSubscriptionDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'deviceIdAbsent' => [[], 'getDeviceId', null];
        yield 'deviceIdWrongType' => [[DeviceSubscriptionDetailTransformerInterface::KEY_DEVICE_ID => 42], 'getDeviceId', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceSubscriptionDetailTransformer();

        $actual = $transformer->transform([DeviceSubscriptionDetailTransformerInterface::KEY_DEVICE_ID => 'test-device-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'componentIdAbsent' => [[], 'getComponentId', null];
        yield 'componentIdWrongType' => [[DeviceSubscriptionDetailTransformerInterface::KEY_COMPONENT_ID => 42], 'getComponentId', null];
        yield 'componentIdValid' => [[DeviceSubscriptionDetailTransformerInterface::KEY_COMPONENT_ID => 'test-component-id'], 'getComponentId', 'test-component-id'];
        yield 'capabilityAbsent' => [[], 'getCapability', null];
        yield 'capabilityWrongType' => [[DeviceSubscriptionDetailTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
        yield 'capabilityValid' => [[DeviceSubscriptionDetailTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getCapability', 'test-capability'];
        yield 'attributeAbsent' => [[], 'getAttribute', null];
        yield 'attributeWrongType' => [[DeviceSubscriptionDetailTransformerInterface::KEY_ATTRIBUTE => 42], 'getAttribute', null];
        yield 'attributeValid' => [[DeviceSubscriptionDetailTransformerInterface::KEY_ATTRIBUTE => 'test-attribute'], 'getAttribute', 'test-attribute'];
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[DeviceSubscriptionDetailTransformerInterface::KEY_VALUE => 'not-array'], 'getValue', null];
        yield 'valueValid' => [[DeviceSubscriptionDetailTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value']], 'getValue', ['test-value-key' => 'test-value']];
        yield 'stateChangeOnlyAbsent' => [[], 'getStateChangeOnly', null];
        yield 'stateChangeOnlyWrongType' => [[DeviceSubscriptionDetailTransformerInterface::KEY_STATE_CHANGE_ONLY => 'not-bool'], 'getStateChangeOnly', null];
        yield 'stateChangeOnlyValid' => [[DeviceSubscriptionDetailTransformerInterface::KEY_STATE_CHANGE_ONLY => true], 'getStateChangeOnly', true];
        yield 'subscriptionNameAbsent' => [[], 'getSubscriptionName', null];
        yield 'subscriptionNameWrongType' => [[DeviceSubscriptionDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 42], 'getSubscriptionName', null];
        yield 'subscriptionNameValid' => [[DeviceSubscriptionDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name'], 'getSubscriptionName', 'test-subscription-name'];
        yield 'modesAbsent' => [[], 'getModes', null];
        yield 'modesWrongType' => [[DeviceSubscriptionDetailTransformerInterface::KEY_MODES => 'not-array'], 'getModes', null];
        yield 'modesValid' => [[DeviceSubscriptionDetailTransformerInterface::KEY_MODES => ['test-modes-1', 'test-modes-2']], 'getModes', ['test-modes-1', 'test-modes-2']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new DeviceSubscriptionDetailTransformer();

        $actual = $transformer->transform([DeviceSubscriptionDetailTransformerInterface::KEY_DEVICE_ID => 'test-device-id']);

        self::assertNull($actual->getComponentId());
        self::assertNull($actual->getCapability());
        self::assertNull($actual->getAttribute());
        self::assertNull($actual->getValue());
        self::assertNull($actual->getStateChangeOnly());
        self::assertNull($actual->getSubscriptionName());
        self::assertNull($actual->getModes());
    }
}
