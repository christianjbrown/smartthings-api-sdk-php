<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\TextButtonButtonsItem;
use ChristianBrown\SmartThings\Transformer\TextButtonButtonsItemTransformer;
use ChristianBrown\SmartThings\Transformer\TextButtonButtonsItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(TextButtonButtonsItem::class)]
#[CoversClass(TextButtonButtonsItemTransformer::class)]
final class TextButtonButtonsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            TextButtonButtonsItemTransformerInterface::KEY_KEY => 'test-key',
            TextButtonButtonsItemTransformerInterface::KEY_LABEL => 'test-label',
            TextButtonButtonsItemTransformerInterface::KEY_STATE => 'test-state',
        ];

        $transformer = new TextButtonButtonsItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-key', $actual->getKey());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-state', $actual->getState());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new TextButtonButtonsItemTransformer();

        $actual = $transformer->transform([TextButtonButtonsItemTransformerInterface::KEY_KEY => 'test-key', TextButtonButtonsItemTransformerInterface::KEY_LABEL => 'test-label'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'stateAbsent' => [[], 'getState', null];
        yield 'stateWrongType' => [[TextButtonButtonsItemTransformerInterface::KEY_STATE => 42], 'getState', null];
        yield 'stateValid' => [[TextButtonButtonsItemTransformerInterface::KEY_STATE => 'test-state'], 'getState', 'test-state'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new TextButtonButtonsItemTransformer();

        $actual = $transformer->transform([TextButtonButtonsItemTransformerInterface::KEY_KEY => 'test-key', TextButtonButtonsItemTransformerInterface::KEY_LABEL => 'test-label']);

        self::assertNull($actual->getState());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new TextButtonButtonsItemTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'keyAbsent' => [[TextButtonButtonsItemTransformerInterface::KEY_LABEL => 'test-label'], sprintf(TextButtonButtonsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, TextButtonButtonsItemTransformerInterface::KEY_KEY)];
        yield 'keyWrongType' => [[TextButtonButtonsItemTransformerInterface::KEY_LABEL => 'test-label', TextButtonButtonsItemTransformerInterface::KEY_KEY => 42], sprintf(TextButtonButtonsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, TextButtonButtonsItemTransformerInterface::KEY_KEY)];
        yield 'labelAbsent' => [[TextButtonButtonsItemTransformerInterface::KEY_KEY => 'test-key'], sprintf(TextButtonButtonsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, TextButtonButtonsItemTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[TextButtonButtonsItemTransformerInterface::KEY_KEY => 'test-key', TextButtonButtonsItemTransformerInterface::KEY_LABEL => 42], sprintf(TextButtonButtonsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, TextButtonButtonsItemTransformerInterface::KEY_LABEL)];
    }
}
