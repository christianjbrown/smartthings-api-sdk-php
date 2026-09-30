<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ApiError;
use ChristianBrown\SmartThings\Transformer\ApiErrorTransformer;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApiErrorTransformer::class)]
#[CoversClass(ApiError::class)]
#[CoversClass(ValueReader::class)]
final class ApiErrorTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new ApiErrorTransformer(new ValueReader()))->transform([]);

        self::assertNull($actual->getCode());
        self::assertNull($actual->getMessage());
        self::assertNull($actual->getTarget());
        self::assertSame([], $actual->getDetails());
    }

    public function testTransformReadsTheErrorAndItsNestedDetails(): void
    {
        $actual = (new ApiErrorTransformer(new ValueReader()))->transform([
            'code' => 'ConstraintViolationError',
            'message' => 'The request is invalid',
            'target' => 'name',
            'details' => [
                ['code' => 'PatternError', 'message' => 'Bad pattern', 'target' => 'name', 'details' => [['code' => 'Deep']]],
                'skipped',
            ],
        ]);

        self::assertSame('ConstraintViolationError', $actual->getCode());
        self::assertSame('The request is invalid', $actual->getMessage());
        self::assertSame('name', $actual->getTarget());
        self::assertCount(1, $actual->getDetails());
        self::assertSame('PatternError', $actual->getDetails()[0]->getCode());
        self::assertSame('Deep', $actual->getDetails()[0]->getDetails()[0]->getCode());
    }
}
