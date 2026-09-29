<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItem;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfoItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfosItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfosItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceConfigurationDpInfosItem::class)]
#[CoversClass(DeviceConfigurationDpInfosItemTransformer::class)]
final class DeviceConfigurationDpInfosItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $data = [
            DeviceConfigurationDpInfosItemTransformerInterface::KEY_ST_PLUGIN_API_VERSION => 'test-st-plugin-api-version',
            DeviceConfigurationDpInfosItemTransformerInterface::KEY_DP_INFO => [['test-nested']],
        ];

        $transformer = new DeviceConfigurationDpInfosItemTransformer($deviceConfigurationDpInfoItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-st-plugin-api-version', $actual->getStPluginApiVersion());
        self::assertSame([$deviceConfigurationDpInfoItemModel], $actual->getDpInfo());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigurationDpInfosItemTransformer(self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class));

        $actual = $transformer->transform([DeviceConfigurationDpInfosItemTransformerInterface::KEY_DP_INFO => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'stPluginApiVersionAbsent' => [[], 'getStPluginApiVersion', null];
        yield 'stPluginApiVersionWrongType' => [[DeviceConfigurationDpInfosItemTransformerInterface::KEY_ST_PLUGIN_API_VERSION => 42], 'getStPluginApiVersion', null];
        yield 'stPluginApiVersionValid' => [[DeviceConfigurationDpInfosItemTransformerInterface::KEY_ST_PLUGIN_API_VERSION => 'test-st-plugin-api-version'], 'getStPluginApiVersion', 'test-st-plugin-api-version'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $transformer = new DeviceConfigurationDpInfosItemTransformer($deviceConfigurationDpInfoItemTransformer);

        $actual = $transformer->transform([DeviceConfigurationDpInfosItemTransformerInterface::KEY_DP_INFO => ['test-nested']]);

        self::assertNull($actual->getStPluginApiVersion());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DeviceConfigurationDpInfosItemTransformer(self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'dpInfoAbsent' => [[], sprintf(DeviceConfigurationDpInfosItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceConfigurationDpInfosItemTransformerInterface::KEY_DP_INFO)];
        yield 'dpInfoWrongType' => [[DeviceConfigurationDpInfosItemTransformerInterface::KEY_DP_INFO => 'not-array'], sprintf(DeviceConfigurationDpInfosItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceConfigurationDpInfosItemTransformerInterface::KEY_DP_INFO)];
    }
}
