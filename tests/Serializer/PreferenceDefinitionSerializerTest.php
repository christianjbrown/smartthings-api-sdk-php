<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PreferenceDefinition;
use ChristianBrown\SmartThings\Serializer\PreferenceDefinitionSerializer;
use ChristianBrown\SmartThings\Serializer\PreferenceDefinitionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PreferenceDefinition::class)]
#[CoversClass(PreferenceDefinitionSerializer::class)]
final class PreferenceDefinitionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new PreferenceDefinition();

        $serializer = new PreferenceDefinitionSerializer();

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new PreferenceDefinition())
            ->setMinimum(1.5)
            ->setMaximum(1.5)
            ->setMinLength(7)
            ->setMaxLength(7)
            ->setDefaultValue('test-default')
            ->setStringType('test-string-type')
            ->setOptions(['test-options-key' => 'test-value']);

        $serializer = new PreferenceDefinitionSerializer();

        self::assertSame(
            [
                PreferenceDefinitionSerializerInterface::KEY_MINIMUM => 1.5,
                PreferenceDefinitionSerializerInterface::KEY_MAXIMUM => 1.5,
                PreferenceDefinitionSerializerInterface::KEY_MIN_LENGTH => 7,
                PreferenceDefinitionSerializerInterface::KEY_MAX_LENGTH => 7,
                PreferenceDefinitionSerializerInterface::KEY_DEFAULT => 'test-default',
                PreferenceDefinitionSerializerInterface::KEY_STRING_TYPE => 'test-string-type',
                PreferenceDefinitionSerializerInterface::KEY_OPTIONS => ['test-options-key' => 'test-value'],
            ],
            $serializer->serialize($model)
        );
    }
}
