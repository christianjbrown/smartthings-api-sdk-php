<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoSubscription;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoSubscriptionTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoSubscriptionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ServiceLocationInfoSubscription::class)]
#[CoversClass(ServiceLocationInfoSubscriptionTransformer::class)]
final class ServiceLocationInfoSubscriptionTransformerTest extends TestCase
{
    /**
     * Exercises the optional predicate/type fields (absent / wrong-type / valid)
     * and the subscribedCapabilities list (absent / non-array / filtering out
     * non-string elements).
     *
     * @param array<string, mixed> $data
     * @param array<int, string>   $expectedSubscribedCapabilities
     */
    #[DataProvider('provideTransformCases')]
    public function testTransform(array $data, array $expectedSubscribedCapabilities, ?string $expectedPredicate, ?string $expectedType): void
    {
        $transformer = new ServiceLocationInfoSubscriptionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-subscription-id', $actual->getSubscriptionId());
        self::assertSame($expectedSubscribedCapabilities, $actual->getSubscribedCapabilities());
        self::assertSame($expectedPredicate, $actual->getPredicate());
        self::assertSame($expectedType, $actual->getType());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, array<int, string>, ?string, ?string}>
     */
    public static function provideTransformCases(): iterable
    {
        $id = ServiceLocationInfoSubscriptionTransformerInterface::KEY_SUBSCRIPTION_ID;
        $predicate = ServiceLocationInfoSubscriptionTransformerInterface::KEY_PREDICATE;
        $type = ServiceLocationInfoSubscriptionTransformerInterface::KEY_TYPE;
        $capabilities = ServiceLocationInfoSubscriptionTransformerInterface::KEY_SUBSCRIBED_CAPABILITIES;

        yield 'allValid' => [[$id => 'test-subscription-id', $predicate => 'weather.temperature.value > 4', $type => 'DIRECT', $capabilities => ['weather', 'airQuality']], ['weather', 'airQuality'], 'weather.temperature.value > 4', 'DIRECT'];
        yield 'allAbsent' => [[$id => 'test-subscription-id'], [], null, null];
        yield 'predicateWrongType' => [[$id => 'test-subscription-id', $predicate => 42], [], null, null];
        yield 'typeWrongType' => [[$id => 'test-subscription-id', $type => 42], [], null, null];
        yield 'subscribedCapabilitiesNonArray' => [[$id => 'test-subscription-id', $capabilities => 'weather'], [], null, null];
        yield 'subscribedCapabilitiesFiltersNonStrings' => [[$id => 'test-subscription-id', $capabilities => ['weather', 42]], ['weather'], null, null];
        yield 'subscribedCapabilitiesLeadingNonString' => [[$id => 'test-subscription-id', $capabilities => [42, 'weather']], ['weather'], null, null];
        yield 'subscribedCapabilitiesAllNonStrings' => [[$id => 'test-subscription-id', $capabilities => [42]], [], null, null];
        yield 'subscribedCapabilitiesMultipleNonStrings' => [[$id => 'test-subscription-id', $capabilities => [42, 43]], [], null, null];
        yield 'subscribedCapabilitiesEmpty' => [[$id => 'test-subscription-id', $capabilities => []], [], null, null];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ServiceLocationInfoSubscriptionTransformerInterface::KEY_SUBSCRIPTION_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new ServiceLocationInfoSubscriptionTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ServiceLocationInfoSubscriptionTransformerInterface::UNEXPECTED_STRING_SPRINTF, ServiceLocationInfoSubscriptionTransformerInterface::KEY_SUBSCRIPTION_ID));
        $transformer->transform($data);
    }
}
