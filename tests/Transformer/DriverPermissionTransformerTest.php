<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DriverPermission;
use ChristianBrown\SmartThings\Transformer\DriverPermissionTransformer;
use ChristianBrown\SmartThings\Transformer\DriverPermissionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DriverPermissionTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'nameAbsent' => [[DriverPermissionTransformerInterface::KEY_ATTRIBUTES => ['test-attributes-key' => 'test-value']], sprintf(DriverPermissionTransformerInterface::UNEXPECTED_STRING_SPRINTF, DriverPermissionTransformerInterface::KEY_NAME)];
        yield 'nameWrongType' => [[DriverPermissionTransformerInterface::KEY_ATTRIBUTES => ['test-attributes-key' => 'test-value'], DriverPermissionTransformerInterface::KEY_NAME => 42], sprintf(DriverPermissionTransformerInterface::UNEXPECTED_STRING_SPRINTF, DriverPermissionTransformerInterface::KEY_NAME)];
        yield 'attributesAbsent' => [[DriverPermissionTransformerInterface::KEY_NAME => 'test-name'], sprintf(DriverPermissionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DriverPermissionTransformerInterface::KEY_ATTRIBUTES)];
        yield 'attributesWrongType' => [[DriverPermissionTransformerInterface::KEY_NAME => 'test-name', DriverPermissionTransformerInterface::KEY_ATTRIBUTES => 'not-array'], sprintf(DriverPermissionTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DriverPermissionTransformerInterface::KEY_ATTRIBUTES)];
    }
}
