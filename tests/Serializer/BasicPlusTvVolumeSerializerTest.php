<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvVolume;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommandInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvVolumeCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvVolumeSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvVolumeSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusTvVolume::class)]
#[CoversClass(BasicPlusTvVolumeSerializer::class)]
final class BasicPlusTvVolumeSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $basicPlusTvVolumeCommandModel = self::createStub(BasicPlusTvVolumeCommandInterface::class);
        $basicPlusTvVolumeCommandSerializer = self::createStub(BasicPlusTvVolumeCommandSerializerInterface::class);
        $basicPlusTvVolumeCommandSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv-volume-command']);
        $model = new BasicPlusTvVolume('test-capability', 'test-component', $basicPlusTvVolumeCommandModel);

        $serializer = new BasicPlusTvVolumeSerializer($basicPlusTvVolumeCommandSerializer);

        self::assertSame(
            [
                BasicPlusTvVolumeSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusTvVolumeSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusTvVolumeSerializerInterface::KEY_COMMAND => ['test-serialized-basic-plus-tv-volume-command'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $basicPlusTvVolumeCommandModel = self::createStub(BasicPlusTvVolumeCommandInterface::class);
        $basicPlusTvVolumeCommandSerializer = self::createStub(BasicPlusTvVolumeCommandSerializerInterface::class);
        $basicPlusTvVolumeCommandSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-tv-volume-command']);
        $model = (new BasicPlusTvVolume('test-capability', 'test-component', $basicPlusTvVolumeCommandModel))
            ->setVersion(7)
            ->setLabel('test-label')
            ->setValue('test-value')
            ->setStep(1.5)
            ->setRange(['test-range-key' => 'test-value'])
            ->setSupportedValues('test-supported-values');

        $serializer = new BasicPlusTvVolumeSerializer($basicPlusTvVolumeCommandSerializer);

        self::assertSame(
            [
                BasicPlusTvVolumeSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusTvVolumeSerializerInterface::KEY_VERSION => 7,
                BasicPlusTvVolumeSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusTvVolumeSerializerInterface::KEY_LABEL => 'test-label',
                BasicPlusTvVolumeSerializerInterface::KEY_COMMAND => ['test-serialized-basic-plus-tv-volume-command'],
                BasicPlusTvVolumeSerializerInterface::KEY_VALUE => 'test-value',
                BasicPlusTvVolumeSerializerInterface::KEY_STEP => 1.5,
                BasicPlusTvVolumeSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                BasicPlusTvVolumeSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            ],
            $serializer->serialize($model)
        );
    }
}
