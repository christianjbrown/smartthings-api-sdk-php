<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\IfActionExecutionResult;
use ChristianBrown\SmartThings\Transformer\IfActionExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\IfActionExecutionResultTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(IfActionExecutionResultTransformer::class)]
#[CoversClass(IfActionExecutionResult::class)]
#[CoversClass(ValueReader::class)]
final class IfActionExecutionResultTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new IfActionExecutionResultTransformer(new ValueReader()))->transform([]);

        self::assertNull($actual->getResult());
    }

    public function testTransformReadsEveryField(): void
    {
        $actual = (new IfActionExecutionResultTransformer(new ValueReader()))->transform([
            IfActionExecutionResultTransformerInterface::KEY_RESULT => 'test-result',
        ]);

        self::assertSame('test-result', $actual->getResult());
    }
}
