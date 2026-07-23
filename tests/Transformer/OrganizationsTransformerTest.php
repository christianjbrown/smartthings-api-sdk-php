<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\OrganizationInterface;
use ChristianBrown\SmartThings\Transformer\OrganizationsTransformer;
use ChristianBrown\SmartThings\Transformer\OrganizationsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\OrganizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(OrganizationsTransformer::class)]
final class OrganizationsTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [['test-organization-1'], ['test-organization-2']];

        $first = self::createStub(OrganizationInterface::class);
        $second = self::createStub(OrganizationInterface::class);

        $organizationTransformer = self::createMock(OrganizationTransformerInterface::class);
        $organizationTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($first, $second);

        $transformer = new OrganizationsTransformer($organizationTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $organizationTransformer = self::createMock(OrganizationTransformerInterface::class);
        $organizationTransformer->expects(self::never())
            ->method('transform');

        $transformer = new OrganizationsTransformer($organizationTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $organizationTransformer = self::createStub(OrganizationTransformerInterface::class);

        $transformer = new OrganizationsTransformer($organizationTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrganizationsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, OrganizationsTransformerInterface::ARRAY_NAME));
        $transformer->transform(['test-not-an-array']);
    }
}
