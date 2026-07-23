<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Subscription;
use ChristianBrown\SmartThings\Transformer\SubscriptionTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(Subscription::class)]
#[CoversClass(SubscriptionTransformer::class)]
final class SubscriptionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SubscriptionTransformerInterface::KEY_ID => 'test-subscription-id',
            SubscriptionTransformerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id',
            SubscriptionTransformerInterface::KEY_SOURCE_TYPE => 'DEVICE',
        ];

        $transformer = new SubscriptionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-subscription-id', $actual->getId());
        self::assertSame('test-installed-app-id', $actual->getInstalledAppId());
        self::assertSame('DEVICE', $actual->getSourceType());
    }

    /**
     * Exercises the optional installedAppId and sourceType fields in each of
     * their three states: absent, present-but-wrong-type, or valid.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedInstalledAppId, ?string $expectedSourceType): void
    {
        $transformer = new SubscriptionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-subscription-id', $actual->getId());
        self::assertSame($expectedInstalledAppId, $actual->getInstalledAppId());
        self::assertSame($expectedSourceType, $actual->getSourceType());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $installedAppIdStates = [
            'installedAppIdAbsent' => [null, null],
            'installedAppIdWrongType' => [42, null],
            'installedAppIdValid' => ['test-installed-app-id', 'test-installed-app-id'],
        ];
        $sourceTypeStates = [
            'sourceTypeAbsent' => [null, null],
            'sourceTypeWrongType' => [42, null],
            'sourceTypeValid' => ['DEVICE', 'DEVICE'],
        ];

        foreach ($installedAppIdStates as $installedAppIdName => [$installedAppIdValue, $expectedInstalledAppId]) {
            foreach ($sourceTypeStates as $sourceTypeName => [$sourceTypeValue, $expectedSourceType]) {
                $data = [SubscriptionTransformerInterface::KEY_ID => 'test-subscription-id'];
                if (null !== $installedAppIdValue) {
                    $data[SubscriptionTransformerInterface::KEY_INSTALLED_APP_ID] = $installedAppIdValue;
                }
                if (null !== $sourceTypeValue) {
                    $data[SubscriptionTransformerInterface::KEY_SOURCE_TYPE] = $sourceTypeValue;
                }

                yield sprintf('%s, %s', $installedAppIdName, $sourceTypeName) => [$data, $expectedInstalledAppId, $expectedSourceType];
            }
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[SubscriptionTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new SubscriptionTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SubscriptionTransformerInterface::UNEXPECTED_STRING_SPRINTF, SubscriptionTransformerInterface::KEY_ID));
        $transformer->transform($data);
    }
}
