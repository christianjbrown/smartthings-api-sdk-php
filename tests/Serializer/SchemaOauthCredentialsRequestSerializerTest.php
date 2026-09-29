<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\SchemaOauthCredentialsRequest;
use ChristianBrown\SmartThings\Serializer\SchemaOauthCredentialsRequestSerializer;
use ChristianBrown\SmartThings\Serializer\SchemaOauthCredentialsRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaOauthCredentialsRequest::class)]
#[CoversClass(SchemaOauthCredentialsRequestSerializer::class)]
final class SchemaOauthCredentialsRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new SchemaOauthCredentialsRequest();

        $serializer = new SchemaOauthCredentialsRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new SchemaOauthCredentialsRequest())
            ->setEndpointAppId('test-endpoint-app-id');

        $serializer = new SchemaOauthCredentialsRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                SchemaOauthCredentialsRequestSerializerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id',
            ],
            $actual
        );
    }
}
