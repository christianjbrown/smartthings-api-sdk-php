<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityConfiguration;
use ChristianBrown\SmartThings\Model\CapabilityConfigurationValueInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationValueTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new CapabilityConfigurationTransformer(self::createStub(CapabilityConfigurationValueTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'valuesAbsent' => [[], sprintf(CapabilityConfigurationTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CapabilityConfigurationTransformerInterface::KEY_VALUES)];
        yield 'valuesWrongType' => [[CapabilityConfigurationTransformerInterface::KEY_VALUES => 'not-array'], sprintf(CapabilityConfigurationTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CapabilityConfigurationTransformerInterface::KEY_VALUES)];
    }
}
