<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilitySubscriptionDetail;
use ChristianBrown\SmartThings\Transformer\CapabilitySubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilitySubscriptionDetailTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CapabilitySubscriptionDetail::class)]
#[CoversClass(CapabilitySubscriptionDetailTransformer::class)]
final class CapabilitySubscriptionDetailTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CapabilitySubscriptionDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            CapabilitySubscriptionDetailTransformerInterface::KEY_CAPABILITY => 'test-capability',
            CapabilitySubscriptionDetailTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
            CapabilitySubscriptionDetailTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
            CapabilitySubscriptionDetailTransformerInterface::KEY_STATE_CHANGE_ONLY => true,
            CapabilitySubscriptionDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
            CapabilitySubscriptionDetailTransformerInterface::KEY_MODES => ['test-modes-1', 'test-modes-2'],
        ];

        $transformer = new CapabilitySubscriptionDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-location-id', $actual->getLocationId());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame('test-attribute', $actual->getAttribute());
        self::assertSame(['test-value-key' => 'test-value'], $actual->getValue());
        self::assertTrue($actual->getStateChangeOnly());
        self::assertSame('test-subscription-name', $actual->getSubscriptionName());
        self::assertSame(['test-modes-1', 'test-modes-2'], $actual->getModes());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CapabilitySubscriptionDetailTransformer();

        $actual = $transformer->transform([CapabilitySubscriptionDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id', CapabilitySubscriptionDetailTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'attributeAbsent' => [[], 'getAttribute', null];
        yield 'attributeWrongType' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_ATTRIBUTE => 42], 'getAttribute', null];
        yield 'attributeValid' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_ATTRIBUTE => 'test-attribute'], 'getAttribute', 'test-attribute'];
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_VALUE => 'not-array'], 'getValue', null];
        yield 'valueValid' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value']], 'getValue', ['test-value-key' => 'test-value']];
        yield 'stateChangeOnlyAbsent' => [[], 'getStateChangeOnly', null];
        yield 'stateChangeOnlyWrongType' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_STATE_CHANGE_ONLY => 'not-bool'], 'getStateChangeOnly', null];
        yield 'stateChangeOnlyValid' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_STATE_CHANGE_ONLY => true], 'getStateChangeOnly', true];
        yield 'subscriptionNameAbsent' => [[], 'getSubscriptionName', null];
        yield 'subscriptionNameWrongType' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 42], 'getSubscriptionName', null];
        yield 'subscriptionNameValid' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name'], 'getSubscriptionName', 'test-subscription-name'];
        yield 'modesAbsent' => [[], 'getModes', null];
        yield 'modesWrongType' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_MODES => 'not-array'], 'getModes', null];
        yield 'modesValid' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_MODES => ['test-modes-1', 'test-modes-2']], 'getModes', ['test-modes-1', 'test-modes-2']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new CapabilitySubscriptionDetailTransformer();

        $actual = $transformer->transform([CapabilitySubscriptionDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id', CapabilitySubscriptionDetailTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getAttribute());
        self::assertNull($actual->getValue());
        self::assertNull($actual->getStateChangeOnly());
        self::assertNull($actual->getSubscriptionName());
        self::assertNull($actual->getModes());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new CapabilitySubscriptionDetailTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'locationIdAbsent' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(CapabilitySubscriptionDetailTransformerInterface::UNEXPECTED_STRING_SPRINTF, CapabilitySubscriptionDetailTransformerInterface::KEY_LOCATION_ID)];
        yield 'locationIdWrongType' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_CAPABILITY => 'test-capability', CapabilitySubscriptionDetailTransformerInterface::KEY_LOCATION_ID => 42], sprintf(CapabilitySubscriptionDetailTransformerInterface::UNEXPECTED_STRING_SPRINTF, CapabilitySubscriptionDetailTransformerInterface::KEY_LOCATION_ID)];
        yield 'capabilityAbsent' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id'], sprintf(CapabilitySubscriptionDetailTransformerInterface::UNEXPECTED_STRING_SPRINTF, CapabilitySubscriptionDetailTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[CapabilitySubscriptionDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id', CapabilitySubscriptionDetailTransformerInterface::KEY_CAPABILITY => 42], sprintf(CapabilitySubscriptionDetailTransformerInterface::UNEXPECTED_STRING_SPRINTF, CapabilitySubscriptionDetailTransformerInterface::KEY_CAPABILITY)];
    }
}
