<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceProfileReference;
use ChristianBrown\SmartThings\Transformer\DeviceProfileReferenceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileReferenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceProfileReference::class)]
#[CoversClass(DeviceProfileReferenceTransformer::class)]
final class DeviceProfileReferenceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceProfileReferenceTransformerInterface::KEY_ID => 'test-id',
        ];

        $transformer = new DeviceProfileReferenceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-id', $actual->getId());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceProfileReferenceTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'idAbsent' => [[], 'getId', null];
        yield 'idWrongType' => [[DeviceProfileReferenceTransformerInterface::KEY_ID => 42], 'getId', null];
        yield 'idValid' => [[DeviceProfileReferenceTransformerInterface::KEY_ID => 'test-id'], 'getId', 'test-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new DeviceProfileReferenceTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getId());
    }
}
