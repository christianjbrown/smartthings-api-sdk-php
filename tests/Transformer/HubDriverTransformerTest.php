<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\HubDriver;
use ChristianBrown\SmartThings\Transformer\HubDriverTransformer;
use ChristianBrown\SmartThings\Transformer\HubDriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(HubDriver::class)]
#[CoversClass(HubDriverTransformer::class)]
final class HubDriverTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            HubDriverTransformerInterface::KEY_DRIVER_VERSION => 'test-driver-version',
            HubDriverTransformerInterface::KEY_DRIVER_ID => 'test-driver-id',
            HubDriverTransformerInterface::KEY_CHANNEL_ID => 'test-channel-id',
        ];

        $transformer = new HubDriverTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-driver-version', $actual->getDriverVersion());
        self::assertSame('test-driver-id', $actual->getDriverId());
        self::assertSame('test-channel-id', $actual->getChannelId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new HubDriverTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'driverIdAbsent' => [[], 'getDriverId', null];
        yield 'driverIdWrongType' => [[HubDriverTransformerInterface::KEY_DRIVER_ID => 42], 'getDriverId', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new HubDriverTransformer();

        $actual = $transformer->transform([HubDriverTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'driverVersionAbsent' => [[], 'getDriverVersion', null];
        yield 'driverVersionWrongType' => [[HubDriverTransformerInterface::KEY_DRIVER_VERSION => 42], 'getDriverVersion', null];
        yield 'driverVersionValid' => [[HubDriverTransformerInterface::KEY_DRIVER_VERSION => 'test-driver-version'], 'getDriverVersion', 'test-driver-version'];
        yield 'channelIdAbsent' => [[], 'getChannelId', null];
        yield 'channelIdWrongType' => [[HubDriverTransformerInterface::KEY_CHANNEL_ID => 42], 'getChannelId', null];
        yield 'channelIdValid' => [[HubDriverTransformerInterface::KEY_CHANNEL_ID => 'test-channel-id'], 'getChannelId', 'test-channel-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new HubDriverTransformer();

        $actual = $transformer->transform([HubDriverTransformerInterface::KEY_DRIVER_ID => 'test-driver-id']);

        self::assertNull($actual->getDriverVersion());
        self::assertNull($actual->getChannelId());
    }
}
