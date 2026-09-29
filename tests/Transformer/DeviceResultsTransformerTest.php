<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceResults;
use ChristianBrown\SmartThings\Transformer\DeviceResultsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceResultsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceResults::class)]
#[CoversClass(DeviceResultsTransformer::class)]
final class DeviceResultsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceResultsTransformerInterface::KEY_DEVICE_ID => 'test-device-id',
            DeviceResultsTransformerInterface::KEY_NAME => 'test-name',
        ];

        $transformer = new DeviceResultsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-device-id', $actual->getDeviceId());
        self::assertSame('test-name', $actual->getName());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceResultsTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'deviceIdAbsent' => [[], 'getDeviceId', null];
        yield 'deviceIdWrongType' => [[DeviceResultsTransformerInterface::KEY_DEVICE_ID => 42], 'getDeviceId', null];
        yield 'deviceIdValid' => [[DeviceResultsTransformerInterface::KEY_DEVICE_ID => 'test-device-id'], 'getDeviceId', 'test-device-id'];
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[DeviceResultsTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'nameValid' => [[DeviceResultsTransformerInterface::KEY_NAME => 'test-name'], 'getName', 'test-name'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new DeviceResultsTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getDeviceId());
        self::assertNull($actual->getName());
    }
}
