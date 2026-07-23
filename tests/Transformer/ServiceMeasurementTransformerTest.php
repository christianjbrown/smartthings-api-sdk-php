<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceMeasurement;
use ChristianBrown\SmartThings\Transformer\ServiceMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceMeasurementTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceMeasurement::class)]
#[CoversClass(ServiceMeasurementTransformer::class)]
final class ServiceMeasurementTransformerTest extends TestCase
{
    /**
     * Exercises every value type (int / float / string) alongside the optional
     * unit field's absent / wrong-type / valid branches.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformCases')]
    public function testTransform(array $data, float|int|string $expectedValue, ?string $expectedUnit): void
    {
        $transformer = new ServiceMeasurementTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedValue, $actual->getValue());
        self::assertSame($expectedUnit, $actual->getUnit());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, float|int|string, ?string}>
     */
    public static function provideTransformCases(): iterable
    {
        $value = ServiceMeasurementTransformerInterface::KEY_VALUE;
        $unit = ServiceMeasurementTransformerInterface::KEY_UNIT;

        yield 'intWithUnit' => [[$value => 6, $unit => 'C'], 6, 'C'];
        yield 'floatWithUnit' => [[$value => 16.09, $unit => 'Km'], 16.09, 'Km'];
        yield 'stringWithoutUnit' => [[$value => 'Fair'], 'Fair', null];
        yield 'intZero' => [[$value => 0], 0, null];
        yield 'unitWrongType' => [[$value => 6, $unit => 42], 6, null];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ServiceMeasurementTransformerInterface::KEY_VALUE => ['nested']]])]
    #[TestWith([[ServiceMeasurementTransformerInterface::KEY_VALUE => true]])]
    public function testTransformUnexpectedValue(array $data): void
    {
        $transformer = new ServiceMeasurementTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ServiceMeasurementTransformerInterface::UNEXPECTED_VALUE);
        $transformer->transform($data);
    }
}
