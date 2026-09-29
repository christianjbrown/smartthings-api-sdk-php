<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppDetails;
use ChristianBrown\SmartThings\Model\ViperAppLinksInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ViperAppLinksTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaAppDetails::class)]
#[CoversClass(SchemaAppDetailsTransformer::class)]
final class SchemaAppDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $viperAppLinksModel = self::createStub(ViperAppLinksInterface::class);
        $viperAppLinksTransformer = self::createStub(ViperAppLinksTransformerInterface::class);
        $viperAppLinksTransformer->method('transform')->willReturn($viperAppLinksModel);
        $data = [
            SchemaAppDetailsTransformerInterface::KEY_VIPER_APP_LINKS => ['test-nested'],
        ];

        $transformer = new SchemaAppDetailsTransformer($viperAppLinksTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($viperAppLinksModel, $actual->getViperAppLinks());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $viperAppLinksModel = self::createStub(ViperAppLinksInterface::class);
        $viperAppLinksTransformer = self::createStub(ViperAppLinksTransformerInterface::class);
        $viperAppLinksTransformer->method('transform')->willReturn($viperAppLinksModel);
        $transformer = new SchemaAppDetailsTransformer($viperAppLinksTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getViperAppLinks());
    }

    public function testTransformViperAppLinks(): void
    {
        $viperAppLinksModel = self::createStub(ViperAppLinksInterface::class);
        $viperAppLinksTransformer = self::createStub(ViperAppLinksTransformerInterface::class);
        $viperAppLinksTransformer->method('transform')->willReturn($viperAppLinksModel);
        $transformer = new SchemaAppDetailsTransformer($viperAppLinksTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getViperAppLinks());
        self::assertNull($transformer->transform($base + [SchemaAppDetailsTransformerInterface::KEY_VIPER_APP_LINKS => 'test-not-array'])->getViperAppLinks());
        self::assertSame($viperAppLinksModel, $transformer->transform($base + [SchemaAppDetailsTransformerInterface::KEY_VIPER_APP_LINKS => ['test-nested']])->getViperAppLinks());
    }
}
