<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityData;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemInterface;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataDetailsInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceMeasurementsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceCapabilityData::class)]
#[CoversClass(ServiceCapabilityDataTransformer::class)]
final class ServiceCapabilityDataTransformerExtendedTest extends TestCase
{
    /**
     * Each new plain field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ServiceCapabilityDataTransformer(self::createStub(ServiceMeasurementsTransformerInterface::class), self::createStub(ServiceCapabilityDataDetailsTransformerInterface::class));

        $actual = $transformer->transform([ServiceCapabilityDataTransformerInterface::KEY_LOCATION_ID => 'test-location-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', []];
        yield 'nameWrongType' => [[ServiceCapabilityDataTransformerInterface::KEY_NAME => 'not-array'], 'getName', []];
        yield 'nameValid' => [[ServiceCapabilityDataTransformerInterface::KEY_NAME => ['test-name-1', 42, 'test-name-2']], 'getName', ['test-name-1', 'test-name-2']];
    }

    public function testTransformExtendedNestedFields(): void
    {
        $alert = [self::createStub(ServiceCapabilityDataAlertItemInterface::class)];
        $details = self::createStub(ServiceCapabilityDataDetailsInterface::class);
        $details->method('getAlert')->willReturn($alert);

        $data = [ServiceCapabilityDataTransformerInterface::KEY_LOCATION_ID => 'test-location-id'] + [ServiceCapabilityDataTransformerInterface::KEY_ALERT => []];
        $containerTransformer = self::createMock(ServiceCapabilityDataDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new ServiceCapabilityDataTransformer(self::createStub(ServiceMeasurementsTransformerInterface::class), $containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($alert, $actual->getAlert());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(ServiceCapabilityDataDetailsInterface::class);
        $containerTransformer = self::createStub(ServiceCapabilityDataDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new ServiceCapabilityDataTransformer(self::createStub(ServiceMeasurementsTransformerInterface::class), $containerTransformer);

        $actual = $transformer->transform([ServiceCapabilityDataTransformerInterface::KEY_LOCATION_ID => 'test-location-id'] + [ServiceCapabilityDataTransformerInterface::KEY_ALERT => []]);

        self::assertSame([], $actual->getAlert());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(ServiceCapabilityDataDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new ServiceCapabilityDataTransformer(self::createStub(ServiceMeasurementsTransformerInterface::class), $containerTransformer);

        $actual = $transformer->transform([ServiceCapabilityDataTransformerInterface::KEY_LOCATION_ID => 'test-location-id']);

        self::assertSame([], $actual->getAlert());
    }
}
