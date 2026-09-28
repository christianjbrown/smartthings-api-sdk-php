<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\UpdateSignatureTypeRequest;
use ChristianBrown\SmartThings\Serializer\UpdateSignatureTypeRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateSignatureTypeRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UpdateSignatureTypeRequest::class)]
#[CoversClass(UpdateSignatureTypeRequestSerializer::class)]
final class UpdateSignatureTypeRequestSerializerTest extends TestCase
{
    public function testSerializeWithRequiredFieldsOnly(): void
    {
        $request = new UpdateSignatureTypeRequest('test-signature-type');

        $serializer = new UpdateSignatureTypeRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateSignatureTypeRequestSerializerInterface::KEY_SIGNATURE_TYPE => 'test-signature-type',
            ],
            $actual
        );
    }
}
