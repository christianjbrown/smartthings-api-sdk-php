<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Organization;
use ChristianBrown\SmartThings\Transformer\OrganizationTransformer;
use ChristianBrown\SmartThings\Transformer\OrganizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Organization::class)]
#[CoversClass(OrganizationTransformer::class)]
final class OrganizationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            OrganizationTransformerInterface::KEY_ORGANIZATION_ID => 'test-organization-id',
            OrganizationTransformerInterface::KEY_IS_DEFAULT_USER_ORG => true,
            OrganizationTransformerInterface::KEY_LABEL => 'Test Label',
            OrganizationTransformerInterface::KEY_MANUFACTURER_NAME => 'Test Manufacturer',
            OrganizationTransformerInterface::KEY_NAME => 'Test Name',
        ];

        $transformer = new OrganizationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-organization-id', $actual->getOrganizationId());
        self::assertTrue($actual->getIsDefaultUserOrg());
        self::assertSame('Test Label', $actual->getLabel());
        self::assertSame('Test Manufacturer', $actual->getManufacturerName());
        self::assertSame('Test Name', $actual->getName());
    }

    /**
     * Exercises every optional field's absent / wrong-type / valid branches,
     * including the falsy-but-legitimate `false` for the boolean flag.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $data, ?bool $expectedIsDefault, ?string $expectedLabel, ?string $expectedManufacturerName, ?string $expectedName): void
    {
        $transformer = new OrganizationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-organization-id', $actual->getOrganizationId());
        self::assertSame($expectedIsDefault, $actual->getIsDefaultUserOrg());
        self::assertSame($expectedLabel, $actual->getLabel());
        self::assertSame($expectedManufacturerName, $actual->getManufacturerName());
        self::assertSame($expectedName, $actual->getName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?bool, ?string, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        $id = OrganizationTransformerInterface::KEY_ORGANIZATION_ID;
        $default = OrganizationTransformerInterface::KEY_IS_DEFAULT_USER_ORG;
        $label = OrganizationTransformerInterface::KEY_LABEL;
        $manufacturer = OrganizationTransformerInterface::KEY_MANUFACTURER_NAME;
        $name = OrganizationTransformerInterface::KEY_NAME;

        yield 'allAbsent' => [[$id => 'test-organization-id'], null, null, null, null];
        yield 'allValid' => [[$id => 'test-organization-id', $default => true, $label => 'Test Label', $manufacturer => 'Test Manufacturer', $name => 'Test Name'], true, 'Test Label', 'Test Manufacturer', 'Test Name'];
        yield 'isDefaultFalse' => [[$id => 'test-organization-id', $default => false], false, null, null, null];
        yield 'isDefaultWrongType' => [[$id => 'test-organization-id', $default => 'not-a-bool'], null, null, null, null];
        yield 'labelWrongType' => [[$id => 'test-organization-id', $label => 42], null, null, null, null];
        yield 'manufacturerNameWrongType' => [[$id => 'test-organization-id', $manufacturer => 42], null, null, null, null];
        yield 'nameWrongType' => [[$id => 'test-organization-id', $name => 42], null, null, null, null];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[OrganizationTransformerInterface::KEY_ORGANIZATION_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new OrganizationTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrganizationTransformerInterface::UNEXPECTED_STRING_SPRINTF, OrganizationTransformerInterface::KEY_ORGANIZATION_ID));
        $transformer->transform($data);
    }
}
