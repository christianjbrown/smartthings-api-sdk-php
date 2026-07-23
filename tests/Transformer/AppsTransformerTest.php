<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AppInterface;
use ChristianBrown\SmartThings\Transformer\AppsTransformer;
use ChristianBrown\SmartThings\Transformer\AppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AppsTransformer::class)]
final class AppsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-app-1'], ['test-app-2']];

        $app1 = self::createStub(AppInterface::class);
        $app2 = self::createStub(AppInterface::class);
        $apps = [$app1, $app2];

        $appTransformer = self::createStub(AppTransformerInterface::class);
        $appTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-app-1'], $app1],
                    [['test-app-2'], $app2],
                ]
            );

        $transformer = new AppsTransformer($appTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($apps, $actual);
    }

    public function testTransformEmpty(): void
    {
        $appTransformer = self::createStub(AppTransformerInterface::class);

        $transformer = new AppsTransformer($appTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $app1 = self::createStub(AppInterface::class);

        $appTransformer = self::createMock(AppTransformerInterface::class);
        $appTransformer->expects(self::once())->method('transform')
            ->with(['test-app-1'])
            ->willReturn($app1);

        $transformer = new AppsTransformer($appTransformer);

        self::assertSame([$app1], $transformer->transform([['test-app-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $appTransformer = self::createStub(AppTransformerInterface::class);

        $transformer = new AppsTransformer($appTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AppsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AppsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-app-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-app-1-array'], 'test-app-2-not-array', ['test-app-3-array'], 'test-app-4-not-array'];

        $app1 = self::createStub(AppInterface::class);
        $app3 = self::createStub(AppInterface::class);

        $appTransformer = self::createStub(AppTransformerInterface::class);
        $appTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-app-1-array'], $app1],
                    [['test-app-3-array'], $app3],
                ]
            );

        $transformer = new AppsTransformer($appTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AppsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AppsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
