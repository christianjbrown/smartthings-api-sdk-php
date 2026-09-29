<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\App;
use ChristianBrown\SmartThings\Model\AppDetailsInterface;
use ChristianBrown\SmartThings\Model\AppInterface;

use function array_filter;
use function array_flip;
use function array_intersect_key;
use function array_values;
use function is_array;
use function is_bool;
use function is_string;
use function sprintf;

final class AppTransformer implements AppTransformerInterface
{
    private AppDetailsTransformerInterface $appDetailsTransformer;

    public function __construct(AppDetailsTransformerInterface $appDetailsTransformer)
    {
        $this->appDetailsTransformer = $appDetailsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppInterface
    {
        if (empty($data[self::KEY_APP_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_APP_ID));
        }
        if (!is_string($data[self::KEY_APP_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_APP_ID));
        }
        $app = new App($data[self::KEY_APP_ID]);

        self::applyAppName($app, $data);
        self::applyAppType($app, $data);
        self::applyDisplayName($app, $data);

        self::applyPrincipalType($app, $data);
        self::applyClassifications($app, $data);
        self::applyDescription($app, $data);
        self::applySingleInstance($app, $data);
        self::applyInstallMetadata($app, $data);
        self::applyCreatedDate($app, $data);
        self::applyLastUpdatedDate($app, $data);

        $this->applyDetails($app, $data);

        return $app;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppName(App $app, array $data): void
    {
        if (empty($data[self::KEY_APP_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_APP_NAME])) {
            return;
        }
        $app->setAppName($data[self::KEY_APP_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppType(App $app, array $data): void
    {
        if (empty($data[self::KEY_APP_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_APP_TYPE])) {
            return;
        }
        $app->setAppType($data[self::KEY_APP_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyClassifications(App $model, array $data): void
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
    private static function applyCreatedDate(App $model, array $data): void
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
    private static function applyDescription(App $model, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $model->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetails(App $model, array $data): void
    {
        if ([] === array_intersect_key($data, array_flip(self::DETAIL_KEYS))) {
            return;
        }
        $details = $this->appDetailsTransformer->transform($data);
        self::copyIconImage($model, $details);
        self::copyOwner($model, $details);
        self::copyLambdaSmartApp($model, $details);
        self::copyWebhookSmartApp($model, $details);
        self::copyUi($model, $details);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDisplayName(App $app, array $data): void
    {
        if (empty($data[self::KEY_DISPLAY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_DISPLAY_NAME])) {
            return;
        }
        $app->setDisplayName($data[self::KEY_DISPLAY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInstallMetadata(App $model, array $data): void
    {
        if (!isset($data[self::KEY_INSTALL_METADATA])) {
            return;
        }
        if (!is_array($data[self::KEY_INSTALL_METADATA])) {
            return;
        }
        $model->setInstallMetadata(array_filter($data[self::KEY_INSTALL_METADATA], is_string(...)));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLastUpdatedDate(App $model, array $data): void
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
    private static function applyPrincipalType(App $model, array $data): void
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
    private static function applySingleInstance(App $model, array $data): void
    {
        if (!isset($data[self::KEY_SINGLE_INSTANCE])) {
            return;
        }
        if (!is_bool($data[self::KEY_SINGLE_INSTANCE])) {
            return;
        }
        $model->setSingleInstance($data[self::KEY_SINGLE_INSTANCE]);
    }

    private static function copyIconImage(App $model, AppDetailsInterface $details): void
    {
        $model->setIconImage($details->getIconImage());
    }

    private static function copyLambdaSmartApp(App $model, AppDetailsInterface $details): void
    {
        $model->setLambdaSmartApp($details->getLambdaSmartApp());
    }

    private static function copyOwner(App $model, AppDetailsInterface $details): void
    {
        $model->setOwner($details->getOwner());
    }

    private static function copyUi(App $model, AppDetailsInterface $details): void
    {
        $model->setUi($details->getUi());
    }

    private static function copyWebhookSmartApp(App $model, AppDetailsInterface $details): void
    {
        $model->setWebhookSmartApp($details->getWebhookSmartApp());
    }
}
