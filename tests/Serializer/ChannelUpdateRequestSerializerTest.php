<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ChannelUpdateRequest;
use ChristianBrown\SmartThings\Serializer\ChannelUpdateRequestSerializer;
use ChristianBrown\SmartThings\Serializer\ChannelUpdateRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ChannelUpdateRequest::class)]
#[CoversClass(ChannelUpdateRequestSerializer::class)]
final class ChannelUpdateRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new ChannelUpdateRequest();

        $serializer = new ChannelUpdateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new ChannelUpdateRequest())
            ->setName('test-name')
            ->setDescription('test-description')
            ->setTermsOfServiceUrl('test-terms-of-service-url');

        $serializer = new ChannelUpdateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                ChannelUpdateRequestSerializerInterface::KEY_NAME => 'test-name',
                ChannelUpdateRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                ChannelUpdateRequestSerializerInterface::KEY_TERMS_OF_SERVICE_URL => 'test-terms-of-service-url',
            ],
            $actual
        );
    }
}
