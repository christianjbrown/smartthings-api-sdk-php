<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LanguageItem;
use ChristianBrown\SmartThings\Model\PoCodesInterface;
use ChristianBrown\SmartThings\Transformer\LanguageItemTransformer;
use ChristianBrown\SmartThings\Transformer\LanguageItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PoCodesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LanguageItem::class)]
#[CoversClass(LanguageItemTransformer::class)]
final class LanguageItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $poCodesModel = self::createStub(PoCodesInterface::class);
        $poCodesTransformer = self::createStub(PoCodesTransformerInterface::class);
        $poCodesTransformer->method('transform')->willReturn($poCodesModel);
        $data = [
            LanguageItemTransformerInterface::KEY_LOCALE => 'test-locale',
            LanguageItemTransformerInterface::KEY_PO_CODES => [['test-nested']],
        ];

        $transformer = new LanguageItemTransformer($poCodesTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-locale', $actual->getLocale());
        self::assertSame([$poCodesModel], $actual->getPoCodes());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new LanguageItemTransformer(self::createStub(PoCodesTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'localeAbsent' => [[LanguageItemTransformerInterface::KEY_PO_CODES => ['test-nested']], sprintf(LanguageItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, LanguageItemTransformerInterface::KEY_LOCALE)];
        yield 'localeWrongType' => [[LanguageItemTransformerInterface::KEY_PO_CODES => ['test-nested'], LanguageItemTransformerInterface::KEY_LOCALE => 42], sprintf(LanguageItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, LanguageItemTransformerInterface::KEY_LOCALE)];
        yield 'poCodesAbsent' => [[LanguageItemTransformerInterface::KEY_LOCALE => 'test-locale'], sprintf(LanguageItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LanguageItemTransformerInterface::KEY_PO_CODES)];
        yield 'poCodesWrongType' => [[LanguageItemTransformerInterface::KEY_LOCALE => 'test-locale', LanguageItemTransformerInterface::KEY_PO_CODES => 'not-array'], sprintf(LanguageItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, LanguageItemTransformerInterface::KEY_PO_CODES)];
    }
}
