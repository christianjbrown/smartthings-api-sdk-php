<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ModeInterface;
use ChristianBrown\SmartThings\Transformer\ModesTransformer;
use ChristianBrown\SmartThings\Transformer\ModesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ModeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ModesTransformer::class)]
final class ModesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-mode-1'], ['test-mode-2']];

        $mode1 = self::createStub(ModeInterface::class);
        $mode2 = self::createStub(ModeInterface::class);
        $modes = [$mode1, $mode2];

        $modeTransformer = self::createStub(ModeTransformerInterface::class);
        $modeTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-mode-1'], $mode1],
                    [['test-mode-2'], $mode2],
                ]
            );

        $transformer = new ModesTransformer($modeTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($modes, $actual);
    }

    public function testTransformEmpty(): void
    {
        $modeTransformer = self::createStub(ModeTransformerInterface::class);

        $transformer = new ModesTransformer($modeTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $mode1 = self::createStub(ModeInterface::class);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::once())->method('transform')
            ->with(['test-mode-1'])
            ->willReturn($mode1);

        $transformer = new ModesTransformer($modeTransformer);

        self::assertSame([$mode1], $transformer->transform([['test-mode-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $modeTransformer = self::createStub(ModeTransformerInterface::class);

        $transformer = new ModesTransformer($modeTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ModesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ModesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-mode-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-mode-1-array'], 'test-mode-2-not-array', ['test-mode-3-array'], 'test-mode-4-not-array'];

        $mode1 = self::createStub(ModeInterface::class);
        $mode3 = self::createStub(ModeInterface::class);

        $modeTransformer = self::createStub(ModeTransformerInterface::class);
        $modeTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-mode-1-array'], $mode1],
                    [['test-mode-3-array'], $mode3],
                ]
            );

        $transformer = new ModesTransformer($modeTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ModesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ModesTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
