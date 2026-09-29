<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\StepperForPanelItemCommand;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemCommandTransformer;
use ChristianBrown\SmartThings\Transformer\StepperForPanelItemCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(StepperForPanelItemCommand::class)]
#[CoversClass(StepperForPanelItemCommandTransformer::class)]
final class StepperForPanelItemCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            StepperForPanelItemCommandTransformerInterface::KEY_NAME => 'test-name',
            StepperForPanelItemCommandTransformerInterface::KEY_INCREASE => 'test-increase',
            StepperForPanelItemCommandTransformerInterface::KEY_DECREASE => 'test-decrease',
            StepperForPanelItemCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
        ];

        $transformer = new StepperForPanelItemCommandTransformer();

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
        $transformer = new StepperForPanelItemCommandTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[StepperForPanelItemCommandTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'nameValid' => [[StepperForPanelItemCommandTransformerInterface::KEY_NAME => 'test-name'], 'getName', 'test-name'];
        yield 'increaseAbsent' => [[], 'getIncrease', null];
        yield 'increaseWrongType' => [[StepperForPanelItemCommandTransformerInterface::KEY_INCREASE => 42], 'getIncrease', null];
        yield 'increaseValid' => [[StepperForPanelItemCommandTransformerInterface::KEY_INCREASE => 'test-increase'], 'getIncrease', 'test-increase'];
        yield 'decreaseAbsent' => [[], 'getDecrease', null];
        yield 'decreaseWrongType' => [[StepperForPanelItemCommandTransformerInterface::KEY_DECREASE => 42], 'getDecrease', null];
        yield 'decreaseValid' => [[StepperForPanelItemCommandTransformerInterface::KEY_DECREASE => 'test-decrease'], 'getDecrease', 'test-decrease'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[StepperForPanelItemCommandTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[StepperForPanelItemCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new StepperForPanelItemCommandTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getName());
        self::assertNull($actual->getIncrease());
        self::assertNull($actual->getDecrease());
        self::assertNull($actual->getArgumentType());
    }
}
