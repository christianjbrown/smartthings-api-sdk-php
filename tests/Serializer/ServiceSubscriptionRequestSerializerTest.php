<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ServiceSubscriptionRequest;
use ChristianBrown\SmartThings\Serializer\ServiceSubscriptionRequestSerializer;
use ChristianBrown\SmartThings\Serializer\ServiceSubscriptionRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceSubscriptionRequest::class)]
#[CoversClass(ServiceSubscriptionRequestSerializer::class)]
final class ServiceSubscriptionRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new ServiceSubscriptionRequest(['test-capabilities-1', 'test-capabilities-2'], 'test-isa-id');

        $serializer = new ServiceSubscriptionRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                ServiceSubscriptionRequestSerializerInterface::KEY_CAPABILITIES => ['test-capabilities-1', 'test-capabilities-2'],
                ServiceSubscriptionRequestSerializerInterface::KEY_ISA_ID => 'test-isa-id',
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new ServiceSubscriptionRequest(['test-capabilities-1', 'test-capabilities-2'], 'test-isa-id'))
            ->setPostalCode('test-postal-code')
            ->setType('test-type')
            ->setPredicate('test-predicate');

        $serializer = new ServiceSubscriptionRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                ServiceSubscriptionRequestSerializerInterface::KEY_CAPABILITIES => ['test-capabilities-1', 'test-capabilities-2'],
                ServiceSubscriptionRequestSerializerInterface::KEY_ISA_ID => 'test-isa-id',
                ServiceSubscriptionRequestSerializerInterface::KEY_POSTAL_CODE => 'test-postal-code',
                ServiceSubscriptionRequestSerializerInterface::KEY_TYPE => 'test-type',
                ServiceSubscriptionRequestSerializerInterface::KEY_PREDICATE => 'test-predicate',
            ],
            $actual
        );
    }
}
