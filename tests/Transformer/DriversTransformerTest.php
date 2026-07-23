<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DriverInterface;
use ChristianBrown\SmartThings\Transformer\DriversTransformer;
use ChristianBrown\SmartThings\Transformer\DriversTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DriversTransformer::class)]
final class DriversTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [['test-driver-1'], ['test-driver-2']];

        $first = self::createStub(DriverInterface::class);
        $second = self::createStub(DriverInterface::class);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($first, $second);

        $transformer = new DriversTransformer($driverTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::never())
            ->method('transform');

        $transformer = new DriversTransformer($driverTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $driverTransformer = self::createStub(DriverTransformerInterface::class);

        $transformer = new DriversTransformer($driverTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DriversTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DriversTransformerInterface::ARRAY_NAME));
        $transformer->transform(['test-not-an-array']);
    }
}
