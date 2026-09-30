<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SecurityArmStateDetail;
use ChristianBrown\SmartThings\Transformer\SecurityArmStateDetailTransformer;
use ChristianBrown\SmartThings\Transformer\SecurityArmStateDetailTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SecurityArmStateDetail::class)]
#[CoversClass(SecurityArmStateDetailTransformer::class)]
final class SecurityArmStateDetailTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SecurityArmStateDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
            SecurityArmStateDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
        ];

        $transformer = new SecurityArmStateDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-subscription-name', $actual->getSubscriptionName());
        self::assertSame('test-location-id', $actual->getLocationId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new SecurityArmStateDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'locationIdAbsent' => [[], 'getLocationId', null];
        yield 'locationIdWrongType' => [[SecurityArmStateDetailTransformerInterface::KEY_LOCATION_ID => 42], 'getLocationId', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new SecurityArmStateDetailTransformer();

        $actual = $transformer->transform([SecurityArmStateDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'subscriptionNameAbsent' => [[], 'getSubscriptionName', null];
        yield 'subscriptionNameWrongType' => [[SecurityArmStateDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 42], 'getSubscriptionName', null];
        yield 'subscriptionNameValid' => [[SecurityArmStateDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name'], 'getSubscriptionName', 'test-subscription-name'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new SecurityArmStateDetailTransformer();

        $actual = $transformer->transform([SecurityArmStateDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id']);

        self::assertNull($actual->getSubscriptionName());
    }
}
