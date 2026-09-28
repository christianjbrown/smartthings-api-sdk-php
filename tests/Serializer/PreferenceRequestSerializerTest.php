<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PreferenceRequest;
use ChristianBrown\SmartThings\Serializer\PreferenceRequestSerializer;
use ChristianBrown\SmartThings\Serializer\PreferenceRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PreferenceRequest::class)]
#[CoversClass(PreferenceRequestSerializer::class)]
final class PreferenceRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $definition = ['minimum' => -10.0, 'maximum' => 10.0, 'default' => 0.0];
        $request = new PreferenceRequest('tempOffset', 'Temperature Offset', 'number', $definition);

        $serializer = new PreferenceRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                PreferenceRequestSerializerInterface::KEY_NAME => 'tempOffset',
                PreferenceRequestSerializerInterface::KEY_TITLE => 'Temperature Offset',
                PreferenceRequestSerializerInterface::KEY_PREFERENCE_TYPE => 'number',
                PreferenceRequestSerializerInterface::KEY_DEFINITION => $definition,
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $definition = ['minimum' => -10.0, 'maximum' => 10.0, 'default' => 0.0];

        $request = (new PreferenceRequest('tempOffset', 'Temperature Offset', 'number', $definition))
            ->setPreferenceId('example.tempOffset')
            ->setDescription('The offset for a particular temperature setting')
            ->setExplicit(true)
            ->setRequired(false);

        $serializer = new PreferenceRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                PreferenceRequestSerializerInterface::KEY_PREFERENCE_ID => 'example.tempOffset',
                PreferenceRequestSerializerInterface::KEY_NAME => 'tempOffset',
                PreferenceRequestSerializerInterface::KEY_TITLE => 'Temperature Offset',
                PreferenceRequestSerializerInterface::KEY_DESCRIPTION => 'The offset for a particular temperature setting',
                PreferenceRequestSerializerInterface::KEY_EXPLICIT => true,
                PreferenceRequestSerializerInterface::KEY_REQUIRED => false,
                PreferenceRequestSerializerInterface::KEY_PREFERENCE_TYPE => 'number',
                PreferenceRequestSerializerInterface::KEY_DEFINITION => $definition,
            ],
            $actual
        );
    }
}
