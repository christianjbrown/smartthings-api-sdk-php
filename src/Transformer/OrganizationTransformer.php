<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Organization;
use ChristianBrown\SmartThings\Model\OrganizationInterface;

use function is_bool;
use function is_string;
use function sprintf;

final class OrganizationTransformer implements OrganizationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OrganizationInterface
    {
        if (empty($data[self::KEY_ORGANIZATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ORGANIZATION_ID));
        }
        if (!is_string($data[self::KEY_ORGANIZATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ORGANIZATION_ID));
        }
        $organization = new Organization($data[self::KEY_ORGANIZATION_ID]);

        self::applyIsDefaultUserOrg($organization, $data);
        self::applyLabel($organization, $data);
        self::applyManufacturerName($organization, $data);
        self::applyName($organization, $data);

        return $organization;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIsDefaultUserOrg(Organization $organization, array $data): void
    {
        if (!isset($data[self::KEY_IS_DEFAULT_USER_ORG])) {
            return;
        }
        if (!is_bool($data[self::KEY_IS_DEFAULT_USER_ORG])) {
            return;
        }
        $organization->setIsDefaultUserOrg($data[self::KEY_IS_DEFAULT_USER_ORG]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(Organization $organization, array $data): void
    {
        if (empty($data[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return;
        }
        $organization->setLabel($data[self::KEY_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyManufacturerName(Organization $organization, array $data): void
    {
        if (empty($data[self::KEY_MANUFACTURER_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_MANUFACTURER_NAME])) {
            return;
        }
        $organization->setManufacturerName($data[self::KEY_MANUFACTURER_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(Organization $organization, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $organization->setName($data[self::KEY_NAME]);
    }
}
