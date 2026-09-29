<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceResultsInterface;
use ChristianBrown\SmartThings\Model\InstalledSchemaAppDetails;
use ChristianBrown\SmartThings\Model\ViperAppLinksInterface;
use ChristianBrown\SmartThings\Transformer\DeviceResultsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ViperAppLinksTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledSchemaAppDetails::class)]
#[CoversClass(InstalledSchemaAppDetailsTransformer::class)]
final class InstalledSchemaAppDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceResultsModel = self::createStub(DeviceResultsInterface::class);
        $deviceResultsTransformer = self::createStub(DeviceResultsTransformerInterface::class);
        $deviceResultsTransformer->method('transform')->willReturn($deviceResultsModel);
        $viperAppLinksModel = self::createStub(ViperAppLinksInterface::class);
        $viperAppLinksTransformer = self::createStub(ViperAppLinksTransformerInterface::class);
        $viperAppLinksTransformer->method('transform')->willReturn($viperAppLinksModel);
        $data = [
            InstalledSchemaAppDetailsTransformerInterface::KEY_DEVICES => [['test-nested']],
            InstalledSchemaAppDetailsTransformerInterface::KEY_VIPER_APP_LINKS => ['test-nested'],
        ];

        $transformer = new InstalledSchemaAppDetailsTransformer($deviceResultsTransformer, $viperAppLinksTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$deviceResultsModel], $actual->getDevices());
        self::assertSame($viperAppLinksModel, $actual->getViperAppLinks());
    }

    public function testTransformDevices(): void
    {
        $deviceResultsModel = self::createStub(DeviceResultsInterface::class);
        $deviceResultsTransformer = self::createStub(DeviceResultsTransformerInterface::class);
        $deviceResultsTransformer->method('transform')->willReturn($deviceResultsModel);
        $viperAppLinksModel = self::createStub(ViperAppLinksInterface::class);
        $viperAppLinksTransformer = self::createStub(ViperAppLinksTransformerInterface::class);
        $viperAppLinksTransformer->method('transform')->willReturn($viperAppLinksModel);
        $transformer = new InstalledSchemaAppDetailsTransformer($deviceResultsTransformer, $viperAppLinksTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDevices());
        self::assertNull($transformer->transform($base + [InstalledSchemaAppDetailsTransformerInterface::KEY_DEVICES => 'test-not-array'])->getDevices());
        self::assertSame([$deviceResultsModel], $transformer->transform($base + [InstalledSchemaAppDetailsTransformerInterface::KEY_DEVICES => [['test-nested'], 'test-skipped']])->getDevices());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceResultsModel = self::createStub(DeviceResultsInterface::class);
        $deviceResultsTransformer = self::createStub(DeviceResultsTransformerInterface::class);
        $deviceResultsTransformer->method('transform')->willReturn($deviceResultsModel);
        $viperAppLinksModel = self::createStub(ViperAppLinksInterface::class);
        $viperAppLinksTransformer = self::createStub(ViperAppLinksTransformerInterface::class);
        $viperAppLinksTransformer->method('transform')->willReturn($viperAppLinksModel);
        $transformer = new InstalledSchemaAppDetailsTransformer($deviceResultsTransformer, $viperAppLinksTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getDevices());
        self::assertNull($actual->getViperAppLinks());
    }

    public function testTransformViperAppLinks(): void
    {
        $deviceResultsModel = self::createStub(DeviceResultsInterface::class);
        $deviceResultsTransformer = self::createStub(DeviceResultsTransformerInterface::class);
        $deviceResultsTransformer->method('transform')->willReturn($deviceResultsModel);
        $viperAppLinksModel = self::createStub(ViperAppLinksInterface::class);
        $viperAppLinksTransformer = self::createStub(ViperAppLinksTransformerInterface::class);
        $viperAppLinksTransformer->method('transform')->willReturn($viperAppLinksModel);
        $transformer = new InstalledSchemaAppDetailsTransformer($deviceResultsTransformer, $viperAppLinksTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getViperAppLinks());
        self::assertNull($transformer->transform($base + [InstalledSchemaAppDetailsTransformerInterface::KEY_VIPER_APP_LINKS => 'test-not-array'])->getViperAppLinks());
        self::assertSame($viperAppLinksModel, $transformer->transform($base + [InstalledSchemaAppDetailsTransformerInterface::KEY_VIPER_APP_LINKS => ['test-nested']])->getViperAppLinks());
    }
}
