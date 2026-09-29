<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\MatterEndpoint;
use ChristianBrown\SmartThings\Model\MatterEndpointDeviceTypeInterface;
use ChristianBrown\SmartThings\Transformer\MatterEndpointDeviceTypeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\MatterEndpointTransformer;
use ChristianBrown\SmartThings\Transformer\MatterEndpointTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(MatterEndpoint::class)]
#[CoversClass(MatterEndpointTransformer::class)]
final class MatterEndpointTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $matterEndpointDeviceTypeModel = self::createStub(MatterEndpointDeviceTypeInterface::class);
        $matterEndpointDeviceTypeTransformer = self::createStub(MatterEndpointDeviceTypeTransformerInterface::class);
        $matterEndpointDeviceTypeTransformer->method('transform')->willReturn($matterEndpointDeviceTypeModel);
        $data = [
            MatterEndpointTransformerInterface::KEY_ENDPOINT_ID => 7,
            MatterEndpointTransformerInterface::KEY_DEVICE_TYPES => [['test-nested']],
        ];

        $transformer = new MatterEndpointTransformer($matterEndpointDeviceTypeTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(7, $actual->getEndpointId());
        self::assertSame([$matterEndpointDeviceTypeModel], $actual->getDeviceTypes());
    }

    public function testTransformDeviceTypes(): void
    {
        $matterEndpointDeviceTypeModel = self::createStub(MatterEndpointDeviceTypeInterface::class);
        $matterEndpointDeviceTypeTransformer = self::createStub(MatterEndpointDeviceTypeTransformerInterface::class);
        $matterEndpointDeviceTypeTransformer->method('transform')->willReturn($matterEndpointDeviceTypeModel);
        $transformer = new MatterEndpointTransformer($matterEndpointDeviceTypeTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDeviceTypes());
        self::assertNull($transformer->transform($base + [MatterEndpointTransformerInterface::KEY_DEVICE_TYPES => 'test-not-array'])->getDeviceTypes());
        self::assertSame([$matterEndpointDeviceTypeModel], $transformer->transform($base + [MatterEndpointTransformerInterface::KEY_DEVICE_TYPES => [['test-nested'], 'test-skipped']])->getDeviceTypes());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new MatterEndpointTransformer(self::createStub(MatterEndpointDeviceTypeTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'endpointIdAbsent' => [[], 'getEndpointId', null];
        yield 'endpointIdWrongType' => [[MatterEndpointTransformerInterface::KEY_ENDPOINT_ID => 'not-int'], 'getEndpointId', null];
        yield 'endpointIdValid' => [[MatterEndpointTransformerInterface::KEY_ENDPOINT_ID => 7], 'getEndpointId', 7];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $matterEndpointDeviceTypeModel = self::createStub(MatterEndpointDeviceTypeInterface::class);
        $matterEndpointDeviceTypeTransformer = self::createStub(MatterEndpointDeviceTypeTransformerInterface::class);
        $matterEndpointDeviceTypeTransformer->method('transform')->willReturn($matterEndpointDeviceTypeModel);
        $transformer = new MatterEndpointTransformer($matterEndpointDeviceTypeTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getEndpointId());
        self::assertNull($actual->getDeviceTypes());
    }
}
