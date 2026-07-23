<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledAppConfigInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledAppConfigsTransformer::class)]
final class InstalledAppConfigsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-config-1'], ['test-config-2']];

        $config1 = self::createStub(InstalledAppConfigInterface::class);
        $config2 = self::createStub(InstalledAppConfigInterface::class);
        $configs = [$config1, $config2];

        $configTransformer = self::createStub(InstalledAppConfigTransformerInterface::class);
        $configTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-config-1'], $config1],
                    [['test-config-2'], $config2],
                ]
            );

        $transformer = new InstalledAppConfigsTransformer($configTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($configs, $actual);
    }

    public function testTransformEmpty(): void
    {
        $configTransformer = self::createStub(InstalledAppConfigTransformerInterface::class);

        $transformer = new InstalledAppConfigsTransformer($configTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $config1 = self::createStub(InstalledAppConfigInterface::class);

        $configTransformer = self::createMock(InstalledAppConfigTransformerInterface::class);
        $configTransformer->expects(self::once())->method('transform')
            ->with(['test-config-1'])
            ->willReturn($config1);

        $transformer = new InstalledAppConfigsTransformer($configTransformer);

        self::assertSame([$config1], $transformer->transform([['test-config-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $configTransformer = self::createStub(InstalledAppConfigTransformerInterface::class);

        $transformer = new InstalledAppConfigsTransformer($configTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstalledAppConfigsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, InstalledAppConfigsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-config-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-config-1-array'], 'test-config-2-not-array', ['test-config-3-array'], 'test-config-4-not-array'];

        $config1 = self::createStub(InstalledAppConfigInterface::class);
        $config3 = self::createStub(InstalledAppConfigInterface::class);

        $configTransformer = self::createStub(InstalledAppConfigTransformerInterface::class);
        $configTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-config-1-array'], $config1],
                    [['test-config-3-array'], $config3],
                ]
            );

        $transformer = new InstalledAppConfigsTransformer($configTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstalledAppConfigsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, InstalledAppConfigsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
