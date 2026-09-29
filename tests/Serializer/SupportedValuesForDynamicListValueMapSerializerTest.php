<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListValueMap;
use ChristianBrown\SmartThings\Serializer\SupportedValuesForDynamicListValueMapSerializer;
use ChristianBrown\SmartThings\Serializer\SupportedValuesForDynamicListValueMapSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SupportedValuesForDynamicListValueMap::class)]
#[CoversClass(SupportedValuesForDynamicListValueMapSerializer::class)]
final class SupportedValuesForDynamicListValueMapSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new SupportedValuesForDynamicListValueMap('test-key', 'test-value');

        $serializer = new SupportedValuesForDynamicListValueMapSerializer();

        self::assertSame(
            [
                SupportedValuesForDynamicListValueMapSerializerInterface::KEY_KEY => 'test-key',
                SupportedValuesForDynamicListValueMapSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }
}
