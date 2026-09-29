<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PageLinksInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInviteInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInvitePage;
use ChristianBrown\SmartThings\Transformer\PageLinksTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppInvitePageTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInvitePageTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaAppInvitePage::class)]
#[CoversClass(SchemaAppInvitePageTransformer::class)]
final class SchemaAppInvitePageTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $schemaAppInviteModel = self::createStub(SchemaAppInviteInterface::class);
        $schemaAppInviteTransformer = self::createStub(SchemaAppInviteTransformerInterface::class);
        $schemaAppInviteTransformer->method('transform')->willReturn($schemaAppInviteModel);
        $pageLinksModel = self::createStub(PageLinksInterface::class);
        $pageLinksTransformer = self::createStub(PageLinksTransformerInterface::class);
        $pageLinksTransformer->method('transform')->willReturn($pageLinksModel);
        $data = [
            SchemaAppInvitePageTransformerInterface::KEY_ITEMS => [['test-nested']],
            SchemaAppInvitePageTransformerInterface::KEY_LINKS => ['test-nested'],
        ];

        $transformer = new SchemaAppInvitePageTransformer($schemaAppInviteTransformer, $pageLinksTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$schemaAppInviteModel], $actual->getItems());
        self::assertSame($pageLinksModel, $actual->getLinks());
    }

    public function testTransformItems(): void
    {
        $schemaAppInviteModel = self::createStub(SchemaAppInviteInterface::class);
        $schemaAppInviteTransformer = self::createStub(SchemaAppInviteTransformerInterface::class);
        $schemaAppInviteTransformer->method('transform')->willReturn($schemaAppInviteModel);
        $pageLinksModel = self::createStub(PageLinksInterface::class);
        $pageLinksTransformer = self::createStub(PageLinksTransformerInterface::class);
        $pageLinksTransformer->method('transform')->willReturn($pageLinksModel);
        $transformer = new SchemaAppInvitePageTransformer($schemaAppInviteTransformer, $pageLinksTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getItems());
        self::assertNull($transformer->transform($base + [SchemaAppInvitePageTransformerInterface::KEY_ITEMS => 'test-not-array'])->getItems());
        self::assertSame([$schemaAppInviteModel], $transformer->transform($base + [SchemaAppInvitePageTransformerInterface::KEY_ITEMS => [['test-nested'], 'test-skipped']])->getItems());
    }

    public function testTransformLinks(): void
    {
        $schemaAppInviteModel = self::createStub(SchemaAppInviteInterface::class);
        $schemaAppInviteTransformer = self::createStub(SchemaAppInviteTransformerInterface::class);
        $schemaAppInviteTransformer->method('transform')->willReturn($schemaAppInviteModel);
        $pageLinksModel = self::createStub(PageLinksInterface::class);
        $pageLinksTransformer = self::createStub(PageLinksTransformerInterface::class);
        $pageLinksTransformer->method('transform')->willReturn($pageLinksModel);
        $transformer = new SchemaAppInvitePageTransformer($schemaAppInviteTransformer, $pageLinksTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getLinks());
        self::assertNull($transformer->transform($base + [SchemaAppInvitePageTransformerInterface::KEY_LINKS => 'test-not-array'])->getLinks());
        self::assertSame($pageLinksModel, $transformer->transform($base + [SchemaAppInvitePageTransformerInterface::KEY_LINKS => ['test-nested']])->getLinks());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $schemaAppInviteModel = self::createStub(SchemaAppInviteInterface::class);
        $schemaAppInviteTransformer = self::createStub(SchemaAppInviteTransformerInterface::class);
        $schemaAppInviteTransformer->method('transform')->willReturn($schemaAppInviteModel);
        $pageLinksModel = self::createStub(PageLinksInterface::class);
        $pageLinksTransformer = self::createStub(PageLinksTransformerInterface::class);
        $pageLinksTransformer->method('transform')->willReturn($pageLinksModel);
        $transformer = new SchemaAppInvitePageTransformer($schemaAppInviteTransformer, $pageLinksTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getItems());
        self::assertNull($actual->getLinks());
    }
}
