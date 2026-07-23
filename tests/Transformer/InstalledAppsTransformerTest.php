<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledAppInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledAppsTransformer::class)]
final class InstalledAppsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-installed-app-1'], ['test-installed-app-2']];

        $installedApp1 = self::createStub(InstalledAppInterface::class);
        $installedApp2 = self::createStub(InstalledAppInterface::class);
        $installedApps = [$installedApp1, $installedApp2];

        $installedAppTransformer = self::createStub(InstalledAppTransformerInterface::class);
        $installedAppTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-installed-app-1'], $installedApp1],
                    [['test-installed-app-2'], $installedApp2],
                ]
            );

        $transformer = new InstalledAppsTransformer($installedAppTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($installedApps, $actual);
    }

    public function testTransformEmpty(): void
    {
        $installedAppTransformer = self::createStub(InstalledAppTransformerInterface::class);

        $transformer = new InstalledAppsTransformer($installedAppTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $installedApp1 = self::createStub(InstalledAppInterface::class);

        $installedAppTransformer = self::createMock(InstalledAppTransformerInterface::class);
        $installedAppTransformer->expects(self::once())->method('transform')
            ->with(['test-installed-app-1'])
            ->willReturn($installedApp1);

        $transformer = new InstalledAppsTransformer($installedAppTransformer);

        self::assertSame([$installedApp1], $transformer->transform([['test-installed-app-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $installedAppTransformer = self::createStub(InstalledAppTransformerInterface::class);

        $transformer = new InstalledAppsTransformer($installedAppTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstalledAppsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, InstalledAppsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-installed-app-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-installed-app-1-array'], 'test-installed-app-2-not-array', ['test-installed-app-3-array'], 'test-installed-app-4-not-array'];

        $installedApp1 = self::createStub(InstalledAppInterface::class);
        $installedApp3 = self::createStub(InstalledAppInterface::class);

        $installedAppTransformer = self::createStub(InstalledAppTransformerInterface::class);
        $installedAppTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-installed-app-1-array'], $installedApp1],
                    [['test-installed-app-3-array'], $installedApp3],
                ]
            );

        $transformer = new InstalledAppsTransformer($installedAppTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstalledAppsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, InstalledAppsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
