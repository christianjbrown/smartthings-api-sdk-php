<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PreferenceOptionLocalization;
use ChristianBrown\SmartThings\Transformer\PreferenceOptionLocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\PreferenceOptionLocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PreferenceOptionLocalization::class)]
#[CoversClass(PreferenceOptionLocalizationTransformer::class)]
final class PreferenceOptionLocalizationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PreferenceOptionLocalizationTransformerInterface::KEY_LABEL => 'test-label',
        ];

        $transformer = new PreferenceOptionLocalizationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PreferenceOptionLocalizationTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'labelAbsent' => [[], sprintf(PreferenceOptionLocalizationTransformerInterface::UNEXPECTED_STRING_SPRINTF, PreferenceOptionLocalizationTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[PreferenceOptionLocalizationTransformerInterface::KEY_LABEL => 42], sprintf(PreferenceOptionLocalizationTransformerInterface::UNEXPECTED_STRING_SPRINTF, PreferenceOptionLocalizationTransformerInterface::KEY_LABEL)];
    }
}
