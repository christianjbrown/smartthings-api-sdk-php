<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledApp;
use ChristianBrown\SmartThings\Model\InstalledAppDetailsInterface;
use ChristianBrown\SmartThings\Model\InstalledAppInterface;

use function array_filter;
use function array_flip;
use function array_intersect_key;
use function array_values;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;
use function sprintf;

final class InstalledAppTransformer implements InstalledAppTransformerInterface
{
    private InstalledAppDetailsTransformerInterface $installedAppDetailsTransformer;

    public function __construct(InstalledAppDetailsTransformerInterface $installedAppDetailsTransformer)
    {
        $this->installedAppDetailsTransformer = $installedAppDetailsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledAppInterface
    {
        if (empty($data[self::KEY_INSTALLED_APP_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_INSTALLED_APP_ID));
        }
        if (!is_string($data[self::KEY_INSTALLED_APP_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_INSTALLED_APP_ID));
        }
        $installedApp = new InstalledApp($data[self::KEY_INSTALLED_APP_ID]);

        self::applyAppId($installedApp, $data);
        self::applyDisplayName($installedApp, $data);
        self::applyInstalledAppStatus($installedApp, $data);
        self::applyInstalledAppType($installedApp, $data);
        self::applyLocationId($installedApp, $data);

        self::applyReferenceId($installedApp, $data);
        self::applyCreatedDate($installedApp, $data);
        self::applyLastUpdatedDate($installedApp, $data);
        self::applyClassifications($installedApp, $data);
        self::applyPrincipalType($installedApp, $data);
        self::applyRestrictionTier($installedApp, $data);
        self::applySingleInstance($installedApp, $data);
        self::applyAllowed($installedApp, $data);

        $this->applyDetails($installedApp, $data);

        return $installedApp;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAllowed(InstalledApp $model, array $data): void
    {
        if (!isset($data[self::KEY_ALLOWED])) {
            return;
        }
        if (!is_array($data[self::KEY_ALLOWED])) {
            return;
        }
        $model->setAllowed(array_values(array_filter($data[self::KEY_ALLOWED], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppId(InstalledApp $installedApp, array $data): void
    {
        if (empty($data[self::KEY_APP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_APP_ID])) {
            return;
        }
        $installedApp->setAppId($data[self::KEY_APP_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyClassifications(InstalledApp $model, array $data): void
    {
        if (!isset($data[self::KEY_CLASSIFICATIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_CLASSIFICATIONS])) {
            return;
        }
        $model->setClassifications(array_values(array_filter($data[self::KEY_CLASSIFICATIONS], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCreatedDate(InstalledApp $model, array $data): void
    {
        if (empty($data[self::KEY_CREATED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_CREATED_DATE])) {
            return;
        }
        $model->setCreatedDate($data[self::KEY_CREATED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetails(InstalledApp $model, array $data): void
    {
        if ([] === array_intersect_key($data, array_flip(self::DETAIL_KEYS))) {
            return;
        }
        $details = $this->installedAppDetailsTransformer->transform($data);
        self::copyOwner($model, $details);
        self::copyNotices($model, $details);
        self::copyUi($model, $details);
        self::copyIconImage($model, $details);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDisplayName(InstalledApp $installedApp, array $data): void
    {
        if (empty($data[self::KEY_DISPLAY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_DISPLAY_NAME])) {
            return;
        }
        $installedApp->setDisplayName($data[self::KEY_DISPLAY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInstalledAppStatus(InstalledApp $installedApp, array $data): void
    {
        if (empty($data[self::KEY_INSTALLED_APP_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_INSTALLED_APP_STATUS])) {
            return;
        }
        $installedApp->setInstalledAppStatus($data[self::KEY_INSTALLED_APP_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInstalledAppType(InstalledApp $installedApp, array $data): void
    {
        if (empty($data[self::KEY_INSTALLED_APP_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_INSTALLED_APP_TYPE])) {
            return;
        }
        $installedApp->setInstalledAppType($data[self::KEY_INSTALLED_APP_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLastUpdatedDate(InstalledApp $model, array $data): void
    {
        if (empty($data[self::KEY_LAST_UPDATED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_LAST_UPDATED_DATE])) {
            return;
        }
        $model->setLastUpdatedDate($data[self::KEY_LAST_UPDATED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationId(InstalledApp $installedApp, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $installedApp->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPrincipalType(InstalledApp $model, array $data): void
    {
        if (empty($data[self::KEY_PRINCIPAL_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_PRINCIPAL_TYPE])) {
            return;
        }
        $model->setPrincipalType($data[self::KEY_PRINCIPAL_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReferenceId(InstalledApp $model, array $data): void
    {
        if (empty($data[self::KEY_REFERENCE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_REFERENCE_ID])) {
            return;
        }
        $model->setReferenceId($data[self::KEY_REFERENCE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRestrictionTier(InstalledApp $model, array $data): void
    {
        if (!isset($data[self::KEY_RESTRICTION_TIER])) {
            return;
        }
        if (!is_int($data[self::KEY_RESTRICTION_TIER])) {
            return;
        }
        $model->setRestrictionTier($data[self::KEY_RESTRICTION_TIER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySingleInstance(InstalledApp $model, array $data): void
    {
        if (!isset($data[self::KEY_SINGLE_INSTANCE])) {
            return;
        }
        if (!is_bool($data[self::KEY_SINGLE_INSTANCE])) {
            return;
        }
        $model->setSingleInstance($data[self::KEY_SINGLE_INSTANCE]);
    }

    private static function copyIconImage(InstalledApp $model, InstalledAppDetailsInterface $details): void
    {
        $model->setIconImage($details->getIconImage());
    }

    private static function copyNotices(InstalledApp $model, InstalledAppDetailsInterface $details): void
    {
        $model->setNotices($details->getNotices() ?? []);
    }

    private static function copyOwner(InstalledApp $model, InstalledAppDetailsInterface $details): void
    {
        $model->setOwner($details->getOwner());
    }

    private static function copyUi(InstalledApp $model, InstalledAppDetailsInterface $details): void
    {
        $model->setUi($details->getUi());
    }
}
