<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Organization;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Organization::class)]
final class OrganizationTest extends TestCase
{
    public function test(): void
    {
        $organization = new Organization('test-organization-id');
        self::assertSame('test-organization-id', $organization->getOrganizationId());
        self::assertNull($organization->getIsDefaultUserOrg());
        self::assertNull($organization->getLabel());
        self::assertNull($organization->getManufacturerName());
        self::assertNull($organization->getName());

        self::assertSame($organization, $organization->setOrganizationId('test-new-organization-id'));
        self::assertSame($organization, $organization->setIsDefaultUserOrg(true));
        self::assertSame($organization, $organization->setLabel('Test Label'));
        self::assertSame($organization, $organization->setManufacturerName('Test Manufacturer'));
        self::assertSame($organization, $organization->setName('Test Name'));

        self::assertSame('test-new-organization-id', $organization->getOrganizationId());
        self::assertTrue($organization->getIsDefaultUserOrg());
        self::assertSame('Test Label', $organization->getLabel());
        self::assertSame('Test Manufacturer', $organization->getManufacturerName());
        self::assertSame('Test Name', $organization->getName());
    }
}
