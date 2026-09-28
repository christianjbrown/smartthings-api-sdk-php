<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceCommandResultInterface;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceCommandResultsTransformer::class)]
final class DeviceCommandResultsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-result-1'], ['test-result-2']];

        $result1 = self::createStub(DeviceCommandResultInterface::class);
        $result2 = self::createStub(DeviceCommandResultInterface::class);

        $deviceCommandResultTransformer = self::createStub(DeviceCommandResultTransformerInterface::class);
        $deviceCommandResultTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-result-1'], $result1],
                    [['test-result-2'], $result2],
                ]
            );

        $transformer = new DeviceCommandResultsTransformer($deviceCommandResultTransformer);

        self::assertSame([$result1, $result2], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $deviceCommandResultTransformer = self::createStub(DeviceCommandResultTransformerInterface::class);

        $transformer = new DeviceCommandResultsTransformer($deviceCommandResultTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArray(): void
    {
        $deviceCommandResultTransformer = self::createStub(DeviceCommandResultTransformerInterface::class);

        $transformer = new DeviceCommandResultsTransformer($deviceCommandResultTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceCommandResultsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceCommandResultsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-result-not-array']);
    }
}
