<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DriverPermission;
use ChristianBrown\SmartThings\Transformer\DriverPermissionTransformer;
use ChristianBrown\SmartThings\Transformer\DriverPermissionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DriverPermission::class)]
#[CoversClass(DriverPermissionTransformer::class)]
final class DriverPermissionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DriverPermissionTransformerInterface::KEY_NAME => 'test-name',
            DriverPermissionTransformerInterface::KEY_ATTRIBUTES => ['test-attributes-key' => 'test-value'],
        ];

        $transformer = new DriverPermissionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame(['test-attributes-key' => 'test-value'], $actual->getAttributes());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DriverPermissionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'nameAbsent' => [[DriverPermissionTransformerInterface::KEY_ATTRIBUTES => ['test-attributes-key' => 'test-value']], 'getName', null];
        yield 'nameWrongType' => [[DriverPermissionTransformerInterface::KEY_ATTRIBUTES => ['test-attributes-key' => 'test-value'], DriverPermissionTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'attributesAbsent' => [[DriverPermissionTransformerInterface::KEY_NAME => 'test-name'], 'getAttributes', []];
        yield 'attributesWrongType' => [[DriverPermissionTransformerInterface::KEY_NAME => 'test-name', DriverPermissionTransformerInterface::KEY_ATTRIBUTES => 'not-array'], 'getAttributes', []];
    }
}
