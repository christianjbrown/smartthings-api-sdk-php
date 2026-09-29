<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommand;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeCommandTransformer;
use ChristianBrown\SmartThings\Transformer\StepperWithAvailableSizeCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(StepperWithAvailableSizeCommand::class)]
#[CoversClass(StepperWithAvailableSizeCommandTransformer::class)]
final class StepperWithAvailableSizeCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            StepperWithAvailableSizeCommandTransformerInterface::KEY_NAME => 'test-name',
            StepperWithAvailableSizeCommandTransformerInterface::KEY_INCREASE => 'test-increase',
            StepperWithAvailableSizeCommandTransformerInterface::KEY_DECREASE => 'test-decrease',
            StepperWithAvailableSizeCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
        ];

        $transformer = new StepperWithAvailableSizeCommandTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-increase', $actual->getIncrease());
        self::assertSame('test-decrease', $actual->getDecrease());
        self::assertSame('test-argument-type', $actual->getArgumentType());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new StepperWithAvailableSizeCommandTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[StepperWithAvailableSizeCommandTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'nameValid' => [[StepperWithAvailableSizeCommandTransformerInterface::KEY_NAME => 'test-name'], 'getName', 'test-name'];
        yield 'increaseAbsent' => [[], 'getIncrease', null];
        yield 'increaseWrongType' => [[StepperWithAvailableSizeCommandTransformerInterface::KEY_INCREASE => 42], 'getIncrease', null];
        yield 'increaseValid' => [[StepperWithAvailableSizeCommandTransformerInterface::KEY_INCREASE => 'test-increase'], 'getIncrease', 'test-increase'];
        yield 'decreaseAbsent' => [[], 'getDecrease', null];
        yield 'decreaseWrongType' => [[StepperWithAvailableSizeCommandTransformerInterface::KEY_DECREASE => 42], 'getDecrease', null];
        yield 'decreaseValid' => [[StepperWithAvailableSizeCommandTransformerInterface::KEY_DECREASE => 'test-decrease'], 'getDecrease', 'test-decrease'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[StepperWithAvailableSizeCommandTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[StepperWithAvailableSizeCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new StepperWithAvailableSizeCommandTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getName());
        self::assertNull($actual->getIncrease());
        self::assertNull($actual->getDecrease());
        self::assertNull($actual->getArgumentType());
    }
}
