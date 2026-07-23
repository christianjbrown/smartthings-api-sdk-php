<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityNamespaceInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityNamespacesTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityNamespacesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityNamespaceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CapabilityNamespacesTransformer::class)]
final class CapabilityNamespacesTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [['test-namespace-1'], ['test-namespace-2']];

        $first = self::createStub(CapabilityNamespaceInterface::class);
        $second = self::createStub(CapabilityNamespaceInterface::class);

        $namespaceTransformer = self::createMock(CapabilityNamespaceTransformerInterface::class);
        $namespaceTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($first, $second);

        $transformer = new CapabilityNamespacesTransformer($namespaceTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $namespaceTransformer = self::createMock(CapabilityNamespaceTransformerInterface::class);
        $namespaceTransformer->expects(self::never())
            ->method('transform');

        $transformer = new CapabilityNamespacesTransformer($namespaceTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $namespaceTransformer = self::createStub(CapabilityNamespaceTransformerInterface::class);

        $transformer = new CapabilityNamespacesTransformer($namespaceTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilityNamespacesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CapabilityNamespacesTransformerInterface::ARRAY_NAME));
        $transformer->transform(['test-not-an-array']);
    }
}
