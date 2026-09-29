<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ChannelCreateRequest;
use ChristianBrown\SmartThings\Serializer\ChannelCreateRequestSerializer;
use ChristianBrown\SmartThings\Serializer\ChannelCreateRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ChannelCreateRequest::class)]
#[CoversClass(ChannelCreateRequestSerializer::class)]
final class ChannelCreateRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new ChannelCreateRequest();

        $serializer = new ChannelCreateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new ChannelCreateRequest())
            ->setName('test-name')
            ->setDescription('test-description')
            ->setType('test-type')
            ->setTermsOfServiceUrl('test-terms-of-service-url');

        $serializer = new ChannelCreateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                ChannelCreateRequestSerializerInterface::KEY_NAME => 'test-name',
                ChannelCreateRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                ChannelCreateRequestSerializerInterface::KEY_TYPE => 'test-type',
                ChannelCreateRequestSerializerInterface::KEY_TERMS_OF_SERVICE_URL => 'test-terms-of-service-url',
            ],
            $actual
        );
    }
}
