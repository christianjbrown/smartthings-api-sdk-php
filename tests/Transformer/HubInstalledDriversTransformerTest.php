<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubInstalledDriverInterface;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriversTransformer;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriversTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(HubInstalledDriversTransformer::class)]
final class HubInstalledDriversTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [['test-driver-1'], ['test-driver-2']];

        $first = self::createStub(HubInstalledDriverInterface::class);
        $second = self::createStub(HubInstalledDriverInterface::class);

        $driverTransformer = self::createMock(HubInstalledDriverTransformerInterface::class);
        $driverTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($first, $second);

        $transformer = new HubInstalledDriversTransformer($driverTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $driverTransformer = self::createMock(HubInstalledDriverTransformerInterface::class);
        $driverTransformer->expects(self::never())
            ->method('transform');

        $transformer = new HubInstalledDriversTransformer($driverTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $driverTransformer = self::createStub(HubInstalledDriverTransformerInterface::class);

        $transformer = new HubInstalledDriversTransformer($driverTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(HubInstalledDriversTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, HubInstalledDriversTransformerInterface::ARRAY_NAME));
        $transformer->transform(['test-not-an-array']);
    }
}
