<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;
use ChristianBrown\SmartThings\Transformer\LocaleReferencesTransformer;
use ChristianBrown\SmartThings\Transformer\LocaleReferencesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocaleReferenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LocaleReferencesTransformer::class)]
final class LocaleReferencesTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [['test-locale-1'], ['test-locale-2']];

        $first = self::createStub(LocaleReferenceInterface::class);
        $second = self::createStub(LocaleReferenceInterface::class);

        $referenceTransformer = self::createMock(LocaleReferenceTransformerInterface::class);
        $referenceTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($first, $second);

        $transformer = new LocaleReferencesTransformer($referenceTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $referenceTransformer = self::createMock(LocaleReferenceTransformerInterface::class);
        $referenceTransformer->expects(self::never())
            ->method('transform');

        $transformer = new LocaleReferencesTransformer($referenceTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $referenceTransformer = self::createStub(LocaleReferenceTransformerInterface::class);

        $transformer = new LocaleReferencesTransformer($referenceTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocaleReferencesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LocaleReferencesTransformerInterface::ARRAY_NAME));
        $transformer->transform(['test-not-an-array']);
    }
}
