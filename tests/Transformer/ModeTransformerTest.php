<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Mode;
use ChristianBrown\SmartThings\Transformer\ModeTransformer;
use ChristianBrown\SmartThings\Transformer\ModeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(Mode::class)]
#[CoversClass(ModeTransformer::class)]
final class ModeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ModeTransformerInterface::KEY_ID => 'test-mode-id',
            ModeTransformerInterface::KEY_LABEL => 'test-label',
            ModeTransformerInterface::KEY_NAME => 'test-name',
        ];

        $transformer = new ModeTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-mode-id', $actual->getId());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-name', $actual->getName());
    }

    /**
     * Exercises the optional label and name fields in each of their three
     * states: absent, present-but-wrong-type, or present-and-valid.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedLabel, ?string $expectedName): void
    {
        $transformer = new ModeTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-mode-id', $actual->getId());
        self::assertSame($expectedLabel, $actual->getLabel());
        self::assertSame($expectedName, $actual->getName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $labelStates = [
            'labelAbsent' => [null, null],
            'labelWrongType' => [42, null],
            'labelValid' => ['test-label', 'test-label'],
        ];
        $nameStates = [
            'nameAbsent' => [null, null],
            'nameWrongType' => [42, null],
            'nameValid' => ['test-name', 'test-name'],
        ];

        foreach ($labelStates as $labelName => [$labelValue, $expectedLabel]) {
            foreach ($nameStates as $nameName => [$nameValue, $expectedName]) {
                $data = [ModeTransformerInterface::KEY_ID => 'test-mode-id'];
                if (null !== $labelValue) {
                    $data[ModeTransformerInterface::KEY_LABEL] = $labelValue;
                }
                if (null !== $nameValue) {
                    $data[ModeTransformerInterface::KEY_NAME] = $nameValue;
                }

                yield sprintf('%s, %s', $labelName, $nameName) => [$data, $expectedLabel, $expectedName];
            }
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ModeTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new ModeTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ModeTransformerInterface::UNEXPECTED_STRING_SPRINTF, ModeTransformerInterface::KEY_ID));
        $transformer->transform($data);
    }
}
