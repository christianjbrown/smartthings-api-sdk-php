<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityAttributeLabel;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeLabelTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeLabelTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityAttributeLabel::class)]
#[CoversClass(CapabilityAttributeLabelTransformer::class)]
final class CapabilityAttributeLabelTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CapabilityAttributeLabelTransformerInterface::KEY_LABEL => 'test-label',
            CapabilityAttributeLabelTransformerInterface::KEY_DESCRIPTION => 'test-description',
        ];

        $transformer = new CapabilityAttributeLabelTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-description', $actual->getDescription());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityAttributeLabelTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[CapabilityAttributeLabelTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityAttributeLabelTransformer();

        $actual = $transformer->transform([CapabilityAttributeLabelTransformerInterface::KEY_LABEL => 'test-label'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[CapabilityAttributeLabelTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[CapabilityAttributeLabelTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new CapabilityAttributeLabelTransformer();

        $actual = $transformer->transform([CapabilityAttributeLabelTransformerInterface::KEY_LABEL => 'test-label']);

        self::assertNull($actual->getDescription());
    }
}
