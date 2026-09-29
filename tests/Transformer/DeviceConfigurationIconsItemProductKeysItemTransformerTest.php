<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemProductKeysItem;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemProductKeysItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemProductKeysItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DeviceConfigurationIconsItemProductKeysItemTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'mnIdAbsent' => [[DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_SETUP_ID => 'test-setup-id'], sprintf(DeviceConfigurationIconsItemProductKeysItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_MN_ID)];
        yield 'mnIdWrongType' => [[DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_SETUP_ID => 'test-setup-id', DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_MN_ID => 42], sprintf(DeviceConfigurationIconsItemProductKeysItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_MN_ID)];
        yield 'setupIdAbsent' => [[DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_MN_ID => 'test-mn-id'], sprintf(DeviceConfigurationIconsItemProductKeysItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_SETUP_ID)];
        yield 'setupIdWrongType' => [[DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_MN_ID => 'test-mn-id', DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_SETUP_ID => 42], sprintf(DeviceConfigurationIconsItemProductKeysItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationIconsItemProductKeysItemTransformerInterface::KEY_SETUP_ID)];
    }
}
