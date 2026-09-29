<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemSeverity;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemSeverityTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemSeverityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceCapabilityDataAlertItemSeverity::class)]
#[CoversClass(ServiceCapabilityDataAlertItemSeverityTransformer::class)]
final class ServiceCapabilityDataAlertItemSeverityTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ServiceCapabilityDataAlertItemSeverityTransformerInterface::KEY_VALUE => 7,
        ];

        $transformer = new ServiceCapabilityDataAlertItemSeverityTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(7, $actual->getValue());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ServiceCapabilityDataAlertItemSeverityTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[ServiceCapabilityDataAlertItemSeverityTransformerInterface::KEY_VALUE => 'not-int'], 'getValue', null];
        yield 'valueValid' => [[ServiceCapabilityDataAlertItemSeverityTransformerInterface::KEY_VALUE => 7], 'getValue', 7];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new ServiceCapabilityDataAlertItemSeverityTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getValue());
    }
}
