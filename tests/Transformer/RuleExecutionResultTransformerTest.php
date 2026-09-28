<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\RuleExecutionResult;
use ChristianBrown\SmartThings\Transformer\RuleExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\RuleExecutionResultTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(RuleExecutionResult::class)]
#[CoversClass(RuleExecutionResultTransformer::class)]
final class RuleExecutionResultTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            RuleExecutionResultTransformerInterface::KEY_EXECUTION_ID => 'test-execution-id',
            RuleExecutionResultTransformerInterface::KEY_ID => 'test-rule-id',
            RuleExecutionResultTransformerInterface::KEY_RESULT => 'Success',
        ];

        $transformer = new RuleExecutionResultTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-execution-id', $actual->getExecutionId());
        self::assertSame('test-rule-id', $actual->getId());
        self::assertSame('Success', $actual->getResult());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([['test-execution-id-key-missing' => true, RuleExecutionResultTransformerInterface::KEY_ID => 'test-rule-id']])]
    #[TestWith([[RuleExecutionResultTransformerInterface::KEY_EXECUTION_ID => 42, RuleExecutionResultTransformerInterface::KEY_ID => 'test-rule-id']])]
    public function testTransformExecutionIdMissingOrWrongType(array $data): void
    {
        $transformer = new RuleExecutionResultTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RuleExecutionResultTransformerInterface::UNEXPECTED_STRING_SPRINTF, RuleExecutionResultTransformerInterface::KEY_EXECUTION_ID));
        $transformer->transform($data);
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[RuleExecutionResultTransformerInterface::KEY_EXECUTION_ID => 'test-execution-id']])]
    #[TestWith([[RuleExecutionResultTransformerInterface::KEY_EXECUTION_ID => 'test-execution-id', RuleExecutionResultTransformerInterface::KEY_ID => 42]])]
    public function testTransformIdMissingOrWrongType(array $data): void
    {
        $transformer = new RuleExecutionResultTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RuleExecutionResultTransformerInterface::UNEXPECTED_STRING_SPRINTF, RuleExecutionResultTransformerInterface::KEY_ID));
        $transformer->transform($data);
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[RuleExecutionResultTransformerInterface::KEY_EXECUTION_ID => 'test-execution-id', RuleExecutionResultTransformerInterface::KEY_ID => 'test-rule-id']])]
    #[TestWith([[RuleExecutionResultTransformerInterface::KEY_EXECUTION_ID => 'test-execution-id', RuleExecutionResultTransformerInterface::KEY_ID => 'test-rule-id', RuleExecutionResultTransformerInterface::KEY_RESULT => 42]])]
    public function testTransformResultMissingOrWrongType(array $data): void
    {
        $transformer = new RuleExecutionResultTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getResult());
    }
}
