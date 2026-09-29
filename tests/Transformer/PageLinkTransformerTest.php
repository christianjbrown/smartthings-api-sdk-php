<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PageLink;
use ChristianBrown\SmartThings\Transformer\PageLinkTransformer;
use ChristianBrown\SmartThings\Transformer\PageLinkTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PageLink::class)]
#[CoversClass(PageLinkTransformer::class)]
final class PageLinkTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PageLinkTransformerInterface::KEY_HREF => 'test-href',
        ];

        $transformer = new PageLinkTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-href', $actual->getHref());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PageLinkTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'hrefAbsent' => [[], 'getHref', null];
        yield 'hrefWrongType' => [[PageLinkTransformerInterface::KEY_HREF => 42], 'getHref', null];
        yield 'hrefValid' => [[PageLinkTransformerInterface::KEY_HREF => 'test-href'], 'getHref', 'test-href'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new PageLinkTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getHref());
    }
}
