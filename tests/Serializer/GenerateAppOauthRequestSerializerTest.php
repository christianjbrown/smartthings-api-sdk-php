<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\GenerateAppOauthRequest;
use ChristianBrown\SmartThings\Serializer\GenerateAppOauthRequestSerializer;
use ChristianBrown\SmartThings\Serializer\GenerateAppOauthRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GenerateAppOauthRequest::class)]
#[CoversClass(GenerateAppOauthRequestSerializer::class)]
final class GenerateAppOauthRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new GenerateAppOauthRequest();

        $serializer = new GenerateAppOauthRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new GenerateAppOauthRequest())
            ->setClientName('test-client-name')
            ->setScope(['test-scope-1', 'test-scope-2']);

        $serializer = new GenerateAppOauthRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                GenerateAppOauthRequestSerializerInterface::KEY_CLIENT_NAME => 'test-client-name',
                GenerateAppOauthRequestSerializerInterface::KEY_SCOPE => ['test-scope-1', 'test-scope-2'],
            ],
            $actual
        );
    }
}
