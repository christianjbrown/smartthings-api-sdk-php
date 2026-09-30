<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceCategory;
use ChristianBrown\SmartThings\Transformer\DeviceCategoryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCategoryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceCategory::class)]
#[CoversClass(DeviceCategoryTransformer::class)]
final class DeviceCategoryTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceCategoryTransformerInterface::KEY_NAME => 'test-name',
            DeviceCategoryTransformerInterface::KEY_CATEGORY_TYPE => 'test-category-type',
        ];

        $transformer = new DeviceCategoryTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-category-type', $actual->getCategoryType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DeviceCategoryTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'nameAbsent' => [[DeviceCategoryTransformerInterface::KEY_CATEGORY_TYPE => 'test-category-type'], 'getName', null];
        yield 'nameWrongType' => [[DeviceCategoryTransformerInterface::KEY_CATEGORY_TYPE => 'test-category-type', DeviceCategoryTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'categoryTypeAbsent' => [[DeviceCategoryTransformerInterface::KEY_NAME => 'test-name'], 'getCategoryType', null];
        yield 'categoryTypeWrongType' => [[DeviceCategoryTransformerInterface::KEY_NAME => 'test-name', DeviceCategoryTransformerInterface::KEY_CATEGORY_TYPE => 42], 'getCategoryType', null];
    }
}
