<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItem;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemArgumentsItemInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfoItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfoItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceConfigurationDpInfoItem::class)]
#[CoversClass(DeviceConfigurationDpInfoItemTransformer::class)]
final class DeviceConfigurationDpInfoItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceConfigurationDpInfoItemArgumentsItemModel = self::createStub(DeviceConfigurationDpInfoItemArgumentsItemInterface::class);
        $deviceConfigurationDpInfoItemArgumentsItemTransformer = self::createStub(DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemArgumentsItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemArgumentsItemModel);
        $data = [
            DeviceConfigurationDpInfoItemTransformerInterface::KEY_OS => 'test-os',
            DeviceConfigurationDpInfoItemTransformerInterface::KEY_DP_URI => 'test-dp-uri',
            DeviceConfigurationDpInfoItemTransformerInterface::KEY_SERVER_DP_URI => 'test-server-dp-uri',
            DeviceConfigurationDpInfoItemTransformerInterface::KEY_OPERATING_MODE => 'test-operating-mode',
            DeviceConfigurationDpInfoItemTransformerInterface::KEY_ARGUMENTS => [['test-nested']],
        ];

        $transformer = new DeviceConfigurationDpInfoItemTransformer($deviceConfigurationDpInfoItemArgumentsItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-os', $actual->getOs());
        self::assertSame('test-dp-uri', $actual->getDpUri());
        self::assertSame('test-server-dp-uri', $actual->getServerDpUri());
        self::assertSame('test-operating-mode', $actual->getOperatingMode());
        self::assertSame([$deviceConfigurationDpInfoItemArgumentsItemModel], $actual->getArguments());
    }

    public function testTransformArguments(): void
    {
        $deviceConfigurationDpInfoItemArgumentsItemModel = self::createStub(DeviceConfigurationDpInfoItemArgumentsItemInterface::class);
        $deviceConfigurationDpInfoItemArgumentsItemTransformer = self::createStub(DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemArgumentsItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemArgumentsItemModel);
        $transformer = new DeviceConfigurationDpInfoItemTransformer($deviceConfigurationDpInfoItemArgumentsItemTransformer);
        $base = [DeviceConfigurationDpInfoItemTransformerInterface::KEY_OS => 'test-os', DeviceConfigurationDpInfoItemTransformerInterface::KEY_DP_URI => 'test-dp-uri'];

        self::assertNull($transformer->transform($base)->getArguments());
        self::assertNull($transformer->transform($base + [DeviceConfigurationDpInfoItemTransformerInterface::KEY_ARGUMENTS => 'test-not-array'])->getArguments());
        self::assertSame([$deviceConfigurationDpInfoItemArgumentsItemModel], $transformer->transform($base + [DeviceConfigurationDpInfoItemTransformerInterface::KEY_ARGUMENTS => [['test-nested'], 'test-skipped']])->getArguments());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigurationDpInfoItemTransformer(self::createStub(DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::class));

        $actual = $transformer->transform([DeviceConfigurationDpInfoItemTransformerInterface::KEY_OS => 'test-os', DeviceConfigurationDpInfoItemTransformerInterface::KEY_DP_URI => 'test-dp-uri'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'serverDpUriAbsent' => [[], 'getServerDpUri', null];
        yield 'serverDpUriWrongType' => [[DeviceConfigurationDpInfoItemTransformerInterface::KEY_SERVER_DP_URI => 42], 'getServerDpUri', null];
        yield 'serverDpUriValid' => [[DeviceConfigurationDpInfoItemTransformerInterface::KEY_SERVER_DP_URI => 'test-server-dp-uri'], 'getServerDpUri', 'test-server-dp-uri'];
        yield 'operatingModeAbsent' => [[], 'getOperatingMode', null];
        yield 'operatingModeWrongType' => [[DeviceConfigurationDpInfoItemTransformerInterface::KEY_OPERATING_MODE => 42], 'getOperatingMode', null];
        yield 'operatingModeValid' => [[DeviceConfigurationDpInfoItemTransformerInterface::KEY_OPERATING_MODE => 'test-operating-mode'], 'getOperatingMode', 'test-operating-mode'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceConfigurationDpInfoItemArgumentsItemModel = self::createStub(DeviceConfigurationDpInfoItemArgumentsItemInterface::class);
        $deviceConfigurationDpInfoItemArgumentsItemTransformer = self::createStub(DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemArgumentsItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemArgumentsItemModel);
        $transformer = new DeviceConfigurationDpInfoItemTransformer($deviceConfigurationDpInfoItemArgumentsItemTransformer);

        $actual = $transformer->transform([DeviceConfigurationDpInfoItemTransformerInterface::KEY_OS => 'test-os', DeviceConfigurationDpInfoItemTransformerInterface::KEY_DP_URI => 'test-dp-uri']);

        self::assertNull($actual->getServerDpUri());
        self::assertNull($actual->getOperatingMode());
        self::assertNull($actual->getArguments());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DeviceConfigurationDpInfoItemTransformer(self::createStub(DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'osAbsent' => [[DeviceConfigurationDpInfoItemTransformerInterface::KEY_DP_URI => 'test-dp-uri'], sprintf(DeviceConfigurationDpInfoItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationDpInfoItemTransformerInterface::KEY_OS)];
        yield 'osWrongType' => [[DeviceConfigurationDpInfoItemTransformerInterface::KEY_DP_URI => 'test-dp-uri', DeviceConfigurationDpInfoItemTransformerInterface::KEY_OS => 42], sprintf(DeviceConfigurationDpInfoItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationDpInfoItemTransformerInterface::KEY_OS)];
        yield 'dpUriAbsent' => [[DeviceConfigurationDpInfoItemTransformerInterface::KEY_OS => 'test-os'], sprintf(DeviceConfigurationDpInfoItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationDpInfoItemTransformerInterface::KEY_DP_URI)];
        yield 'dpUriWrongType' => [[DeviceConfigurationDpInfoItemTransformerInterface::KEY_OS => 'test-os', DeviceConfigurationDpInfoItemTransformerInterface::KEY_DP_URI => 42], sprintf(DeviceConfigurationDpInfoItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationDpInfoItemTransformerInterface::KEY_DP_URI)];
    }
}
