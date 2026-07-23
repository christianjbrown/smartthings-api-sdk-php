<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledSchemaAppInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(InstalledSchemaAppsTransformer::class)]
final class InstalledSchemaAppsTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [['test-app-1'], ['test-app-2']];

        $first = self::createStub(InstalledSchemaAppInterface::class);
        $second = self::createStub(InstalledSchemaAppInterface::class);

        $appTransformer = self::createMock(InstalledSchemaAppTransformerInterface::class);
        $appTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($first, $second);

        $transformer = new InstalledSchemaAppsTransformer($appTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $appTransformer = self::createMock(InstalledSchemaAppTransformerInterface::class);
        $appTransformer->expects(self::never())
            ->method('transform');

        $transformer = new InstalledSchemaAppsTransformer($appTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $appTransformer = self::createStub(InstalledSchemaAppTransformerInterface::class);

        $transformer = new InstalledSchemaAppsTransformer($appTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstalledSchemaAppsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, InstalledSchemaAppsTransformerInterface::ARRAY_NAME));
        $transformer->transform(['test-not-an-array']);
    }
}
