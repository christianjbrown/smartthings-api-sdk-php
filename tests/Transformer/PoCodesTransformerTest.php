<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PoCodes;
use ChristianBrown\SmartThings\Transformer\PoCodesTransformer;
use ChristianBrown\SmartThings\Transformer\PoCodesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PoCodes::class)]
#[CoversClass(PoCodesTransformer::class)]
final class PoCodesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PoCodesTransformerInterface::KEY_LABEL => 'test-label',
            PoCodesTransformerInterface::KEY_PO => 'test-po',
        ];

        $transformer = new PoCodesTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-po', $actual->getPo());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new PoCodesTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'labelAbsent' => [[PoCodesTransformerInterface::KEY_PO => 'test-po'], 'getLabel', null];
        yield 'labelWrongType' => [[PoCodesTransformerInterface::KEY_PO => 'test-po', PoCodesTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'poAbsent' => [[PoCodesTransformerInterface::KEY_LABEL => 'test-label'], 'getPo', null];
        yield 'poWrongType' => [[PoCodesTransformerInterface::KEY_LABEL => 'test-label', PoCodesTransformerInterface::KEY_PO => 42], 'getPo', null];
    }
}
