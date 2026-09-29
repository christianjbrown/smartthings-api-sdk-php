<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PageLinkInterface;
use ChristianBrown\SmartThings\Model\PageLinks;
use ChristianBrown\SmartThings\Transformer\PageLinksTransformer;
use ChristianBrown\SmartThings\Transformer\PageLinksTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PageLinkTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PageLinks::class)]
#[CoversClass(PageLinksTransformer::class)]
final class PageLinksTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $pageLinkModel = self::createStub(PageLinkInterface::class);
        $pageLinkTransformer = self::createStub(PageLinkTransformerInterface::class);
        $pageLinkTransformer->method('transform')->willReturn($pageLinkModel);
        $data = [
            PageLinksTransformerInterface::KEY_NEXT => ['test-nested'],
            PageLinksTransformerInterface::KEY_PREVIOUS => ['test-nested'],
        ];

        $transformer = new PageLinksTransformer($pageLinkTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($pageLinkModel, $actual->getNext());
        self::assertSame($pageLinkModel, $actual->getPrevious());
    }

    public function testTransformNext(): void
    {
        $pageLinkModel = self::createStub(PageLinkInterface::class);
        $pageLinkTransformer = self::createStub(PageLinkTransformerInterface::class);
        $pageLinkTransformer->method('transform')->willReturn($pageLinkModel);
        $transformer = new PageLinksTransformer($pageLinkTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getNext());
        self::assertNull($transformer->transform($base + [PageLinksTransformerInterface::KEY_NEXT => 'test-not-array'])->getNext());
        self::assertSame($pageLinkModel, $transformer->transform($base + [PageLinksTransformerInterface::KEY_NEXT => ['test-nested']])->getNext());
    }

    public function testTransformPrevious(): void
    {
        $pageLinkModel = self::createStub(PageLinkInterface::class);
        $pageLinkTransformer = self::createStub(PageLinkTransformerInterface::class);
        $pageLinkTransformer->method('transform')->willReturn($pageLinkModel);
        $transformer = new PageLinksTransformer($pageLinkTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getPrevious());
        self::assertNull($transformer->transform($base + [PageLinksTransformerInterface::KEY_PREVIOUS => 'test-not-array'])->getPrevious());
        self::assertSame($pageLinkModel, $transformer->transform($base + [PageLinksTransformerInterface::KEY_PREVIOUS => ['test-nested']])->getPrevious());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $pageLinkModel = self::createStub(PageLinkInterface::class);
        $pageLinkTransformer = self::createStub(PageLinkTransformerInterface::class);
        $pageLinkTransformer->method('transform')->willReturn($pageLinkModel);
        $transformer = new PageLinksTransformer($pageLinkTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getNext());
        self::assertNull($actual->getPrevious());
    }
}
