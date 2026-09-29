<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicList;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListValueMapInterface;
use ChristianBrown\SmartThings\Serializer\SupportedValuesForDynamicListSerializer;
use ChristianBrown\SmartThings\Serializer\SupportedValuesForDynamicListSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SupportedValuesForDynamicListValueMapSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SupportedValuesForDynamicList::class)]
#[CoversClass(SupportedValuesForDynamicListSerializer::class)]
final class SupportedValuesForDynamicListSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $supportedValuesForDynamicListValueMapModel = self::createStub(SupportedValuesForDynamicListValueMapInterface::class);
        $supportedValuesForDynamicListValueMapSerializer = self::createStub(SupportedValuesForDynamicListValueMapSerializerInterface::class);
        $supportedValuesForDynamicListValueMapSerializer->method('serialize')->willReturn(['test-serialized-supported-values-for-dynamic-list-value-map']);
        $model = new SupportedValuesForDynamicList('test-value');

        $serializer = new SupportedValuesForDynamicListSerializer($supportedValuesForDynamicListValueMapSerializer);

        self::assertSame(
            [
                SupportedValuesForDynamicListSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $supportedValuesForDynamicListValueMapModel = self::createStub(SupportedValuesForDynamicListValueMapInterface::class);
        $supportedValuesForDynamicListValueMapSerializer = self::createStub(SupportedValuesForDynamicListValueMapSerializerInterface::class);
        $supportedValuesForDynamicListValueMapSerializer->method('serialize')->willReturn(['test-serialized-supported-values-for-dynamic-list-value-map']);
        $model = (new SupportedValuesForDynamicList('test-value'))
            ->setValueMap($supportedValuesForDynamicListValueMapModel);

        $serializer = new SupportedValuesForDynamicListSerializer($supportedValuesForDynamicListValueMapSerializer);

        self::assertSame(
            [
                SupportedValuesForDynamicListSerializerInterface::KEY_VALUE => 'test-value',
                SupportedValuesForDynamicListSerializerInterface::KEY_VALUE_MAP => ['test-serialized-supported-values-for-dynamic-list-value-map'],
            ],
            $serializer->serialize($model)
        );
    }
}
