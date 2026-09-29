<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PoCodes;
use ChristianBrown\SmartThings\Transformer\PoCodesTransformer;
use ChristianBrown\SmartThings\Transformer\PoCodesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PoCodesTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'labelAbsent' => [[PoCodesTransformerInterface::KEY_PO => 'test-po'], sprintf(PoCodesTransformerInterface::UNEXPECTED_STRING_SPRINTF, PoCodesTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[PoCodesTransformerInterface::KEY_PO => 'test-po', PoCodesTransformerInterface::KEY_LABEL => 42], sprintf(PoCodesTransformerInterface::UNEXPECTED_STRING_SPRINTF, PoCodesTransformerInterface::KEY_LABEL)];
        yield 'poAbsent' => [[PoCodesTransformerInterface::KEY_LABEL => 'test-label'], sprintf(PoCodesTransformerInterface::UNEXPECTED_STRING_SPRINTF, PoCodesTransformerInterface::KEY_PO)];
        yield 'poWrongType' => [[PoCodesTransformerInterface::KEY_LABEL => 'test-label', PoCodesTransformerInterface::KEY_PO => 42], sprintf(PoCodesTransformerInterface::UNEXPECTED_STRING_SPRINTF, PoCodesTransformerInterface::KEY_PO)];
    }
}
