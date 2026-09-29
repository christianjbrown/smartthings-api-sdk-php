<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteRequest;
use ChristianBrown\SmartThings\Serializer\SchemaAppInviteRequestSerializer;
use ChristianBrown\SmartThings\Serializer\SchemaAppInviteRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaAppInviteRequest::class)]
#[CoversClass(SchemaAppInviteRequestSerializer::class)]
final class SchemaAppInviteRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new SchemaAppInviteRequest();

        $serializer = new SchemaAppInviteRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new SchemaAppInviteRequest())
            ->setSchemaAppId('test-schema-app-id')
            ->setDescription('test-description')
            ->setAcceptLimit(7);

        $serializer = new SchemaAppInviteRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                SchemaAppInviteRequestSerializerInterface::KEY_SCHEMA_APP_ID => 'test-schema-app-id',
                SchemaAppInviteRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                SchemaAppInviteRequestSerializerInterface::KEY_ACCEPT_LIMIT => 7,
            ],
            $actual
        );
    }
}
