<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\Restriction;
use ChristianBrown\SmartThings\Serializer\RestrictionSerializer;
use ChristianBrown\SmartThings\Serializer\RestrictionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Restriction::class)]
#[CoversClass(RestrictionSerializer::class)]
final class RestrictionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new Restriction(7);

        $serializer = new RestrictionSerializer();

        self::assertSame(
            [
                RestrictionSerializerInterface::KEY_TIER => 7,
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new Restriction(7))
            ->setHistoryRetentionTTLDays(7)
            ->setVisibleWhenRestricted(true);

        $serializer = new RestrictionSerializer();

        self::assertSame(
            [
                RestrictionSerializerInterface::KEY_TIER => 7,
                RestrictionSerializerInterface::KEY_HISTORY_RETENTION_TTLDAYS => 7,
                RestrictionSerializerInterface::KEY_VISIBLE_WHEN_RESTRICTED => true,
            ],
            $serializer->serialize($model)
        );
    }
}
