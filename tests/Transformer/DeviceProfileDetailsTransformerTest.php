<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileComponentInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileDetails;
use ChristianBrown\SmartThings\Model\DeviceRestrictionInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfileComponentTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfileDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceRestrictionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceProfileDetails::class)]
#[CoversClass(DeviceProfileDetailsTransformer::class)]
final class DeviceProfileDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceRestrictionModel = self::createStub(DeviceRestrictionInterface::class);
        $deviceRestrictionTransformer = self::createStub(DeviceRestrictionTransformerInterface::class);
        $deviceRestrictionTransformer->method('transform')->willReturn($deviceRestrictionModel);
        $devicePreferenceDefinitionModel = self::createStub(DevicePreferenceDefinitionInterface::class);
        $devicePreferenceDefinitionTransformer = self::createStub(DevicePreferenceDefinitionTransformerInterface::class);
        $devicePreferenceDefinitionTransformer->method('transform')->willReturn($devicePreferenceDefinitionModel);
        $deviceProfileComponentModel = self::createStub(DeviceProfileComponentInterface::class);
        $deviceProfileComponentTransformer = self::createStub(DeviceProfileComponentTransformerInterface::class);
        $deviceProfileComponentTransformer->method('transform')->willReturn($deviceProfileComponentModel);
        $data = [
            DeviceProfileDetailsTransformerInterface::KEY_RESTRICTIONS => ['test-nested'],
            DeviceProfileDetailsTransformerInterface::KEY_PREFERENCES => [['test-nested']],
            DeviceProfileDetailsTransformerInterface::KEY_COMPONENTS => [['test-nested']],
        ];

        $transformer = new DeviceProfileDetailsTransformer($deviceRestrictionTransformer, $devicePreferenceDefinitionTransformer, $deviceProfileComponentTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($deviceRestrictionModel, $actual->getRestrictions());
        self::assertSame([$devicePreferenceDefinitionModel], $actual->getPreferences());
        self::assertSame([$deviceProfileComponentModel], $actual->getComponents());
    }

    public function testTransformComponents(): void
    {
        $deviceRestrictionModel = self::createStub(DeviceRestrictionInterface::class);
        $deviceRestrictionTransformer = self::createStub(DeviceRestrictionTransformerInterface::class);
        $deviceRestrictionTransformer->method('transform')->willReturn($deviceRestrictionModel);
        $devicePreferenceDefinitionModel = self::createStub(DevicePreferenceDefinitionInterface::class);
        $devicePreferenceDefinitionTransformer = self::createStub(DevicePreferenceDefinitionTransformerInterface::class);
        $devicePreferenceDefinitionTransformer->method('transform')->willReturn($devicePreferenceDefinitionModel);
        $deviceProfileComponentModel = self::createStub(DeviceProfileComponentInterface::class);
        $deviceProfileComponentTransformer = self::createStub(DeviceProfileComponentTransformerInterface::class);
        $deviceProfileComponentTransformer->method('transform')->willReturn($deviceProfileComponentModel);
        $transformer = new DeviceProfileDetailsTransformer($deviceRestrictionTransformer, $devicePreferenceDefinitionTransformer, $deviceProfileComponentTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getComponents());
        self::assertNull($transformer->transform($base + [DeviceProfileDetailsTransformerInterface::KEY_COMPONENTS => 'test-not-array'])->getComponents());
        self::assertSame([$deviceProfileComponentModel], $transformer->transform($base + [DeviceProfileDetailsTransformerInterface::KEY_COMPONENTS => [['test-nested'], 'test-skipped']])->getComponents());
    }

    public function testTransformPreferences(): void
    {
        $deviceRestrictionModel = self::createStub(DeviceRestrictionInterface::class);
        $deviceRestrictionTransformer = self::createStub(DeviceRestrictionTransformerInterface::class);
        $deviceRestrictionTransformer->method('transform')->willReturn($deviceRestrictionModel);
        $devicePreferenceDefinitionModel = self::createStub(DevicePreferenceDefinitionInterface::class);
        $devicePreferenceDefinitionTransformer = self::createStub(DevicePreferenceDefinitionTransformerInterface::class);
        $devicePreferenceDefinitionTransformer->method('transform')->willReturn($devicePreferenceDefinitionModel);
        $deviceProfileComponentModel = self::createStub(DeviceProfileComponentInterface::class);
        $deviceProfileComponentTransformer = self::createStub(DeviceProfileComponentTransformerInterface::class);
        $deviceProfileComponentTransformer->method('transform')->willReturn($deviceProfileComponentModel);
        $transformer = new DeviceProfileDetailsTransformer($deviceRestrictionTransformer, $devicePreferenceDefinitionTransformer, $deviceProfileComponentTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getPreferences());
        self::assertNull($transformer->transform($base + [DeviceProfileDetailsTransformerInterface::KEY_PREFERENCES => 'test-not-array'])->getPreferences());
        self::assertSame([$devicePreferenceDefinitionModel], $transformer->transform($base + [DeviceProfileDetailsTransformerInterface::KEY_PREFERENCES => [['test-nested'], 'test-skipped']])->getPreferences());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceRestrictionModel = self::createStub(DeviceRestrictionInterface::class);
        $deviceRestrictionTransformer = self::createStub(DeviceRestrictionTransformerInterface::class);
        $deviceRestrictionTransformer->method('transform')->willReturn($deviceRestrictionModel);
        $devicePreferenceDefinitionModel = self::createStub(DevicePreferenceDefinitionInterface::class);
        $devicePreferenceDefinitionTransformer = self::createStub(DevicePreferenceDefinitionTransformerInterface::class);
        $devicePreferenceDefinitionTransformer->method('transform')->willReturn($devicePreferenceDefinitionModel);
        $deviceProfileComponentModel = self::createStub(DeviceProfileComponentInterface::class);
        $deviceProfileComponentTransformer = self::createStub(DeviceProfileComponentTransformerInterface::class);
        $deviceProfileComponentTransformer->method('transform')->willReturn($deviceProfileComponentModel);
        $transformer = new DeviceProfileDetailsTransformer($deviceRestrictionTransformer, $devicePreferenceDefinitionTransformer, $deviceProfileComponentTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getRestrictions());
        self::assertNull($actual->getPreferences());
        self::assertNull($actual->getComponents());
    }

    public function testTransformRestrictions(): void
    {
        $deviceRestrictionModel = self::createStub(DeviceRestrictionInterface::class);
        $deviceRestrictionTransformer = self::createStub(DeviceRestrictionTransformerInterface::class);
        $deviceRestrictionTransformer->method('transform')->willReturn($deviceRestrictionModel);
        $devicePreferenceDefinitionModel = self::createStub(DevicePreferenceDefinitionInterface::class);
        $devicePreferenceDefinitionTransformer = self::createStub(DevicePreferenceDefinitionTransformerInterface::class);
        $devicePreferenceDefinitionTransformer->method('transform')->willReturn($devicePreferenceDefinitionModel);
        $deviceProfileComponentModel = self::createStub(DeviceProfileComponentInterface::class);
        $deviceProfileComponentTransformer = self::createStub(DeviceProfileComponentTransformerInterface::class);
        $deviceProfileComponentTransformer->method('transform')->willReturn($deviceProfileComponentModel);
        $transformer = new DeviceProfileDetailsTransformer($deviceRestrictionTransformer, $devicePreferenceDefinitionTransformer, $deviceProfileComponentTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getRestrictions());
        self::assertNull($transformer->transform($base + [DeviceProfileDetailsTransformerInterface::KEY_RESTRICTIONS => 'test-not-array'])->getRestrictions());
        self::assertSame($deviceRestrictionModel, $transformer->transform($base + [DeviceProfileDetailsTransformerInterface::KEY_RESTRICTIONS => ['test-nested']])->getRestrictions());
    }
}
