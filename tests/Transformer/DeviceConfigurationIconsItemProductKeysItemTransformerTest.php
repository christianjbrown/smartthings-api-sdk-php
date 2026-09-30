<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemProductKeysItem;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemProductKeysItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemProductKeysItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationIconsItemProductKeysItem::class)]
#[CoversClass(DeviceConfigurationIconsItemProductKeysItemTransformer::class)]
final class DeviceConfigurationIconsItemProductKeysItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_MN_ID => 'test-mn-id',
            DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_SETUP_ID => 'test-setup-id',
        ];

        $transformer = new DeviceConfigurationIconsItemProductKeysItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-mn-id', $actual->getMnId());
        self::assertSame('test-setup-id', $actual->getSetupId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigurationIconsItemProductKeysItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'mnIdAbsent' => [[DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_SETUP_ID => 'test-setup-id'], 'getMnId', null];
        yield 'mnIdWrongType' => [[DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_SETUP_ID => 'test-setup-id', DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_MN_ID => 42], 'getMnId', null];
        yield 'setupIdAbsent' => [[DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_MN_ID => 'test-mn-id'], 'getSetupId', null];
        yield 'setupIdWrongType' => [[DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_MN_ID => 'test-mn-id', DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_SETUP_ID => 42], 'getSetupId', null];
    }
}
