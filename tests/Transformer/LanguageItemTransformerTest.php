<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\LanguageItem;
use ChristianBrown\SmartThings\Model\PoCodesInterface;
use ChristianBrown\SmartThings\Transformer\LanguageItemTransformer;
use ChristianBrown\SmartThings\Transformer\LanguageItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PoCodesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

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
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new LanguageItemTransformer(self::createStub(PoCodesTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'localeAbsent' => [[LanguageItemTransformerInterface::KEY_PO_CODES => ['test-nested']], 'getLocale', null];
        yield 'localeWrongType' => [[LanguageItemTransformerInterface::KEY_PO_CODES => ['test-nested'], LanguageItemTransformerInterface::KEY_LOCALE => 42], 'getLocale', null];
        yield 'poCodesAbsent' => [[LanguageItemTransformerInterface::KEY_LOCALE => 'test-locale'], 'getPoCodes', []];
        yield 'poCodesWrongType' => [[LanguageItemTransformerInterface::KEY_LOCALE => 'test-locale', LanguageItemTransformerInterface::KEY_PO_CODES => 'not-array'], 'getPoCodes', []];
    }
}
