<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Driver;
use ChristianBrown\SmartThings\Transformer\DriverTransformer;
use ChristianBrown\SmartThings\Transformer\DriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Driver::class)]
#[CoversClass(DriverTransformer::class)]
final class DriverTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DriverTransformerInterface::KEY_DRIVER_ID => 'test-driver-id',
            DriverTransformerInterface::KEY_DESCRIPTION => 'Test description',
            DriverTransformerInterface::KEY_NAME => 'Test Driver',
            DriverTransformerInterface::KEY_PACKAGE_KEY => 'test-package-key',
            DriverTransformerInterface::KEY_VERSION => '2024-01-01',
        ];

        $transformer = new DriverTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-driver-id', $actual->getDriverId());
        self::assertSame('Test description', $actual->getDescription());
        self::assertSame('Test Driver', $actual->getName());
        self::assertSame('test-package-key', $actual->getPackageKey());
        self::assertSame('2024-01-01', $actual->getVersion());
    }

    /**
     * Exercises every optional field's absent / wrong-type / valid branches.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $data, ?string $expectedDescription, ?string $expectedName, ?string $expectedPackageKey, ?string $expectedVersion): void
    {
        $transformer = new DriverTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-driver-id', $actual->getDriverId());
        self::assertSame($expectedDescription, $actual->getDescription());
        self::assertSame($expectedName, $actual->getName());
        self::assertSame($expectedPackageKey, $actual->getPackageKey());
        self::assertSame($expectedVersion, $actual->getVersion());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        $id = DriverTransformerInterface::KEY_DRIVER_ID;
        $description = DriverTransformerInterface::KEY_DESCRIPTION;
        $name = DriverTransformerInterface::KEY_NAME;
        $packageKey = DriverTransformerInterface::KEY_PACKAGE_KEY;
        $version = DriverTransformerInterface::KEY_VERSION;

        yield 'allAbsent' => [[$id => 'test-driver-id'], null, null, null, null];
        yield 'allValid' => [[$id => 'test-driver-id', $description => 'Test description', $name => 'Test Driver', $packageKey => 'test-package-key', $version => '2024-01-01'], 'Test description', 'Test Driver', 'test-package-key', '2024-01-01'];
        yield 'descriptionWrongType' => [[$id => 'test-driver-id', $description => 42], null, null, null, null];
        yield 'nameWrongType' => [[$id => 'test-driver-id', $name => 42], null, null, null, null];
        yield 'packageKeyWrongType' => [[$id => 'test-driver-id', $packageKey => 42], null, null, null, null];
        yield 'versionWrongType' => [[$id => 'test-driver-id', $version => 42], null, null, null, null];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[DriverTransformerInterface::KEY_DRIVER_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new DriverTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DriverTransformerInterface::UNEXPECTED_STRING_SPRINTF, DriverTransformerInterface::KEY_DRIVER_ID));
        $transformer->transform($data);
    }
}
