<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityConfiguration;
use ChristianBrown\SmartThings\Model\CapabilityConfigurationValueInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationValueTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityConfiguration::class)]
#[CoversClass(CapabilityConfigurationTransformer::class)]
final class CapabilityConfigurationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $capabilityConfigurationValueModel = self::createStub(CapabilityConfigurationValueInterface::class);
        $capabilityConfigurationValueTransformer = self::createStub(CapabilityConfigurationValueTransformerInterface::class);
        $capabilityConfigurationValueTransformer->method('transform')->willReturn($capabilityConfigurationValueModel);
        $data = [
            CapabilityConfigurationTransformerInterface::KEY_VALUES => [['test-nested']],
        ];

        $transformer = new CapabilityConfigurationTransformer($capabilityConfigurationValueTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$capabilityConfigurationValueModel], $actual->getValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityConfigurationTransformer(self::createStub(CapabilityConfigurationValueTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'valuesAbsent' => [[], 'getValues', []];
        yield 'valuesWrongType' => [[CapabilityConfigurationTransformerInterface::KEY_VALUES => 'not-array'], 'getValues', []];
    }
}
