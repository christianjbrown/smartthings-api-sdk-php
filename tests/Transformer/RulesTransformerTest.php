<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\RuleInterface;
use ChristianBrown\SmartThings\Transformer\RulesTransformer;
use ChristianBrown\SmartThings\Transformer\RulesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RuleTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RulesTransformer::class)]
final class RulesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-rule-1'], ['test-rule-2']];

        $rule1 = self::createStub(RuleInterface::class);
        $rule2 = self::createStub(RuleInterface::class);
        $rules = [$rule1, $rule2];

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $ruleTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-rule-1'], $rule1],
                    [['test-rule-2'], $rule2],
                ]
            );

        $transformer = new RulesTransformer($ruleTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($rules, $actual);
    }

    public function testTransformEmpty(): void
    {
        $ruleTransformer = self::createStub(RuleTransformerInterface::class);

        $transformer = new RulesTransformer($ruleTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $rule1 = self::createStub(RuleInterface::class);

        $ruleTransformer = self::createMock(RuleTransformerInterface::class);
        $ruleTransformer->expects(self::once())->method('transform')
            ->with(['test-rule-1'])
            ->willReturn($rule1);

        $transformer = new RulesTransformer($ruleTransformer);

        self::assertSame([$rule1], $transformer->transform([['test-rule-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $ruleTransformer = self::createStub(RuleTransformerInterface::class);

        $transformer = new RulesTransformer($ruleTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RulesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, RulesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-rule-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-rule-1-array'], 'test-rule-2-not-array', ['test-rule-3-array'], 'test-rule-4-not-array'];

        $rule1 = self::createStub(RuleInterface::class);
        $rule3 = self::createStub(RuleInterface::class);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $ruleTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-rule-1-array'], $rule1],
                    [['test-rule-3-array'], $rule3],
                ]
            );

        $transformer = new RulesTransformer($ruleTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RulesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, RulesTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
