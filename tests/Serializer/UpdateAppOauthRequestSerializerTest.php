<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\UpdateAppOauthRequest;
use ChristianBrown\SmartThings\Serializer\UpdateAppOauthRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateAppOauthRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UpdateAppOauthRequest::class)]
#[CoversClass(UpdateAppOauthRequestSerializer::class)]
final class UpdateAppOauthRequestSerializerTest extends TestCase
{
    public function testSerializeWithRequiredFieldsOnly(): void
    {
        $request = new UpdateAppOauthRequest('test-client-name', ['test-scope-1', 'test-scope-2'], ['test-redirect-uris-1', 'test-redirect-uris-2']);

        $serializer = new UpdateAppOauthRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateAppOauthRequestSerializerInterface::KEY_CLIENT_NAME => 'test-client-name',
                UpdateAppOauthRequestSerializerInterface::KEY_SCOPE => ['test-scope-1', 'test-scope-2'],
                UpdateAppOauthRequestSerializerInterface::KEY_REDIRECT_URIS => ['test-redirect-uris-1', 'test-redirect-uris-2'],
            ],
            $actual
        );
    }
}
