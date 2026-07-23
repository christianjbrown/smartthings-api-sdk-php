<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SchemaAppInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppsTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(SchemaAppsTransformer::class)]
final class SchemaAppsTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [['test-app-1'], ['test-app-2']];

        $first = self::createStub(SchemaAppInterface::class);
        $second = self::createStub(SchemaAppInterface::class);

        $appTransformer = self::createMock(SchemaAppTransformerInterface::class);
        $appTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($first, $second);

        $transformer = new SchemaAppsTransformer($appTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $appTransformer = self::createMock(SchemaAppTransformerInterface::class);
        $appTransformer->expects(self::never())
            ->method('transform');

        $transformer = new SchemaAppsTransformer($appTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $appTransformer = self::createStub(SchemaAppTransformerInterface::class);

        $transformer = new SchemaAppsTransformer($appTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SchemaAppsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SchemaAppsTransformerInterface::ARRAY_NAME));
        $transformer->transform(['test-not-an-array']);
    }
}
