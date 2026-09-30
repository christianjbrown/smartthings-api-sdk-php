<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ApiErrorInterface;
use ChristianBrown\SmartThings\Model\ErrorResponse;
use ChristianBrown\SmartThings\Transformer\ApiErrorTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ErrorResponseTransformer;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(ErrorResponseTransformer::class)]
#[CoversClass(ErrorResponse::class)]
#[CoversClass(ValueReader::class)]
final class ErrorResponseTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new ErrorResponseTransformer(self::createStub(ApiErrorTransformerInterface::class), new ValueReader()))->transform([]);

        self::assertNull($actual->getRequestId());
        self::assertNull($actual->getError());
    }

    /**
     * @throws Exception
     */
    public function testTransformReadsTheRequestIdAndTheError(): void
    {
        $error = self::createStub(ApiErrorInterface::class);
        $apiErrorTransformer = self::createMock(ApiErrorTransformerInterface::class);
        $apiErrorTransformer->expects(self::once())->method('transform')->with(['code' => 'NotFound'])->willReturn($error);

        $actual = (new ErrorResponseTransformer($apiErrorTransformer, new ValueReader()))->transform(['requestId' => 'test-request', 'error' => ['code' => 'NotFound']]);

        self::assertSame('test-request', $actual->getRequestId());
        self::assertSame($error, $actual->getError());
    }
}
