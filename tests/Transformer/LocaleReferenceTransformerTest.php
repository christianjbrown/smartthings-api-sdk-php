<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocaleReference;
use ChristianBrown\SmartThings\Transformer\LocaleReferenceTransformer;
use ChristianBrown\SmartThings\Transformer\LocaleReferenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LocaleReference::class)]
#[CoversClass(LocaleReferenceTransformer::class)]
final class LocaleReferenceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $transformer = new LocaleReferenceTransformer();

        $actual = $transformer->transform([LocaleReferenceTransformerInterface::KEY_TAG => 'en']);

        self::assertSame('en', $actual->getTag());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[LocaleReferenceTransformerInterface::KEY_TAG => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new LocaleReferenceTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocaleReferenceTransformerInterface::UNEXPECTED_STRING_SPRINTF, LocaleReferenceTransformerInterface::KEY_TAG));
        $transformer->transform($data);
    }
}
