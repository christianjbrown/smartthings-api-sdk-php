<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceCategory;
use ChristianBrown\SmartThings\Transformer\DeviceCategoryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCategoryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DeviceCategoryTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'nameAbsent' => [[DeviceCategoryTransformerInterface::KEY_CATEGORY_TYPE => 'test-category-type'], sprintf(DeviceCategoryTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceCategoryTransformerInterface::KEY_NAME)];
        yield 'nameWrongType' => [[DeviceCategoryTransformerInterface::KEY_CATEGORY_TYPE => 'test-category-type', DeviceCategoryTransformerInterface::KEY_NAME => 42], sprintf(DeviceCategoryTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceCategoryTransformerInterface::KEY_NAME)];
        yield 'categoryTypeAbsent' => [[DeviceCategoryTransformerInterface::KEY_NAME => 'test-name'], sprintf(DeviceCategoryTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceCategoryTransformerInterface::KEY_CATEGORY_TYPE)];
        yield 'categoryTypeWrongType' => [[DeviceCategoryTransformerInterface::KEY_NAME => 'test-name', DeviceCategoryTransformerInterface::KEY_CATEGORY_TYPE => 42], sprintf(DeviceCategoryTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceCategoryTransformerInterface::KEY_CATEGORY_TYPE)];
    }
}
