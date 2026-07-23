<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Presentation;
use ChristianBrown\SmartThings\Transformer\PresentationTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(Presentation::class)]
#[CoversClass(PresentationTransformer::class)]
final class PresentationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PresentationTransformerInterface::KEY_PRESENTATION_ID => 'test-presentation-id',
            PresentationTransformerInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer',
            PresentationTransformerInterface::KEY_TYPE => 'profile',
        ];

        $transformer = new PresentationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-presentation-id', $actual->getPresentationId());
        self::assertSame('test-manufacturer', $actual->getManufacturerName());
        self::assertSame('profile', $actual->getType());
    }

    /**
     * Exercises the optional manufacturerName and type fields in each of their
     * three states: absent, present-but-wrong-type, or present-and-valid.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedManufacturerName, ?string $expectedType): void
    {
        $transformer = new PresentationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-presentation-id', $actual->getPresentationId());
        self::assertSame($expectedManufacturerName, $actual->getManufacturerName());
        self::assertSame($expectedType, $actual->getType());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $manufacturerNameStates = [
            'manufacturerNameAbsent' => [null, null],
            'manufacturerNameWrongType' => [42, null],
            'manufacturerNameValid' => ['test-manufacturer', 'test-manufacturer'],
        ];
        $typeStates = [
            'typeAbsent' => [null, null],
            'typeWrongType' => [42, null],
            'typeValid' => ['profile', 'profile'],
        ];

        foreach ($manufacturerNameStates as $manufacturerNameName => [$manufacturerNameValue, $expectedManufacturerName]) {
            foreach ($typeStates as $typeName => [$typeValue, $expectedType]) {
                $data = [PresentationTransformerInterface::KEY_PRESENTATION_ID => 'test-presentation-id'];
                if (null !== $manufacturerNameValue) {
                    $data[PresentationTransformerInterface::KEY_MANUFACTURER_NAME] = $manufacturerNameValue;
                }
                if (null !== $typeValue) {
                    $data[PresentationTransformerInterface::KEY_TYPE] = $typeValue;
                }

                yield sprintf('%s, %s', $manufacturerNameName, $typeName) => [$data, $expectedManufacturerName, $expectedType];
            }
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[PresentationTransformerInterface::KEY_PRESENTATION_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new PresentationTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(PresentationTransformerInterface::UNEXPECTED_STRING_SPRINTF, PresentationTransformerInterface::KEY_PRESENTATION_ID));
        $transformer->transform($data);
    }
}
