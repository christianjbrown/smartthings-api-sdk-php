<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubHealthDetail;
use ChristianBrown\SmartThings\Transformer\HubHealthDetailTransformer;
use ChristianBrown\SmartThings\Transformer\HubHealthDetailTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(HubHealthDetail::class)]
#[CoversClass(HubHealthDetailTransformer::class)]
final class HubHealthDetailTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            HubHealthDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
            HubHealthDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
        ];

        $transformer = new HubHealthDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-subscription-name', $actual->getSubscriptionName());
        self::assertSame('test-location-id', $actual->getLocationId());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new HubHealthDetailTransformer();

        $actual = $transformer->transform([HubHealthDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'subscriptionNameAbsent' => [[], 'getSubscriptionName', null];
        yield 'subscriptionNameWrongType' => [[HubHealthDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 42], 'getSubscriptionName', null];
        yield 'subscriptionNameValid' => [[HubHealthDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name'], 'getSubscriptionName', 'test-subscription-name'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new HubHealthDetailTransformer();

        $actual = $transformer->transform([HubHealthDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id']);

        self::assertNull($actual->getSubscriptionName());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new HubHealthDetailTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'locationIdAbsent' => [[], sprintf(HubHealthDetailTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubHealthDetailTransformerInterface::KEY_LOCATION_ID)];
        yield 'locationIdWrongType' => [[HubHealthDetailTransformerInterface::KEY_LOCATION_ID => 42], sprintf(HubHealthDetailTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubHealthDetailTransformerInterface::KEY_LOCATION_ID)];
    }
}
