<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SleepActionExecutionResult;
use ChristianBrown\SmartThings\Transformer\SleepActionExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\SleepActionExecutionResultTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SleepActionExecutionResultTransformer::class)]
#[CoversClass(SleepActionExecutionResult::class)]
#[CoversClass(ValueReader::class)]
final class SleepActionExecutionResultTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new SleepActionExecutionResultTransformer(new ValueReader()))->transform([]);

        self::assertNull($actual->getResult());
    }

    public function testTransformReadsEveryField(): void
    {
        $actual = (new SleepActionExecutionResultTransformer(new ValueReader()))->transform([
            SleepActionExecutionResultTransformerInterface::KEY_RESULT => 'test-result',
        ]);

        self::assertSame('test-result', $actual->getResult());
    }
}
