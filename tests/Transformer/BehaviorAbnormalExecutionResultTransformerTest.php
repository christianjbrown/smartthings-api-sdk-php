<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BehaviorAbnormalExecutionResult;
use ChristianBrown\SmartThings\Transformer\BehaviorAbnormalExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\BehaviorAbnormalExecutionResultTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BehaviorAbnormalExecutionResultTransformer::class)]
#[CoversClass(BehaviorAbnormalExecutionResult::class)]
#[CoversClass(ValueReader::class)]
final class BehaviorAbnormalExecutionResultTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new BehaviorAbnormalExecutionResultTransformer(new ValueReader()))->transform([]);

        self::assertNull($actual->getResult());
        self::assertNull($actual->getReason());
    }

    public function testTransformReadsEveryField(): void
    {
        $actual = (new BehaviorAbnormalExecutionResultTransformer(new ValueReader()))->transform([
            BehaviorAbnormalExecutionResultTransformerInterface::KEY_RESULT => 'test-result',
            BehaviorAbnormalExecutionResultTransformerInterface::KEY_REASON => 'test-reason',
        ]);

        self::assertSame('test-result', $actual->getResult());
        self::assertSame('test-reason', $actual->getReason());
    }
}
