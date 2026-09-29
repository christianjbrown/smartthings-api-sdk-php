<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKey;
use ChristianBrown\SmartThings\Transformer\DeviceIntegrationProfileKeyTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceIntegrationProfileKeyTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceIntegrationProfileKey::class)]
#[CoversClass(DeviceIntegrationProfileKeyTransformer::class)]
final class DeviceIntegrationProfileKeyTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceIntegrationProfileKeyTransformerInterface::KEY_ID => 'test-id',
            DeviceIntegrationProfileKeyTransformerInterface::KEY_MAJOR_VERSION => 7,
        ];

        $transformer = new DeviceIntegrationProfileKeyTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-id', $actual->getId());
        self::assertSame(7, $actual->getMajorVersion());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceIntegrationProfileKeyTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'idAbsent' => [[], 'getId', null];
        yield 'idWrongType' => [[DeviceIntegrationProfileKeyTransformerInterface::KEY_ID => 42], 'getId', null];
        yield 'idValid' => [[DeviceIntegrationProfileKeyTransformerInterface::KEY_ID => 'test-id'], 'getId', 'test-id'];
        yield 'majorVersionAbsent' => [[], 'getMajorVersion', null];
        yield 'majorVersionWrongType' => [[DeviceIntegrationProfileKeyTransformerInterface::KEY_MAJOR_VERSION => 'not-int'], 'getMajorVersion', null];
        yield 'majorVersionValid' => [[DeviceIntegrationProfileKeyTransformerInterface::KEY_MAJOR_VERSION => 7], 'getMajorVersion', 7];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new DeviceIntegrationProfileKeyTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getId());
        self::assertNull($actual->getMajorVersion());
    }
}
