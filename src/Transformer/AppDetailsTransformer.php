<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AppDetails;
use ChristianBrown\SmartThings\Model\AppDetailsInterface;

use function is_array;

final class AppDetailsTransformer implements AppDetailsTransformerInterface
{
    private AppUiSettingsTransformerInterface $appUiSettingsTransformer;
    private IconImageTransformerInterface $iconImageTransformer;
    private LambdaSmartAppTransformerInterface $lambdaSmartAppTransformer;
    private OwnerTransformerInterface $ownerTransformer;
    private WebhookSmartAppTransformerInterface $webhookSmartAppTransformer;

    public function __construct(IconImageTransformerInterface $iconImageTransformer, OwnerTransformerInterface $ownerTransformer, LambdaSmartAppTransformerInterface $lambdaSmartAppTransformer, WebhookSmartAppTransformerInterface $webhookSmartAppTransformer, AppUiSettingsTransformerInterface $appUiSettingsTransformer)
    {
        $this->iconImageTransformer = $iconImageTransformer;
        $this->ownerTransformer = $ownerTransformer;
        $this->lambdaSmartAppTransformer = $lambdaSmartAppTransformer;
        $this->webhookSmartAppTransformer = $webhookSmartAppTransformer;
        $this->appUiSettingsTransformer = $appUiSettingsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppDetailsInterface
    {
        $model = new AppDetails();

        $this->applyIconImage($model, $data);
        $this->applyOwner($model, $data);
        $this->applyLambdaSmartApp($model, $data);
        $this->applyWebhookSmartApp($model, $data);
        $this->applyUi($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyIconImage(AppDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_ICON_IMAGE])) {
            return;
        }
        if (!is_array($data[self::KEY_ICON_IMAGE])) {
            return;
        }
        $model->setIconImage($this->iconImageTransformer->transform($data[self::KEY_ICON_IMAGE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLambdaSmartApp(AppDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_LAMBDA_SMART_APP])) {
            return;
        }
        if (!is_array($data[self::KEY_LAMBDA_SMART_APP])) {
            return;
        }
        $model->setLambdaSmartApp($this->lambdaSmartAppTransformer->transform($data[self::KEY_LAMBDA_SMART_APP]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyOwner(AppDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_OWNER])) {
            return;
        }
        if (!is_array($data[self::KEY_OWNER])) {
            return;
        }
        $model->setOwner($this->ownerTransformer->transform($data[self::KEY_OWNER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyUi(AppDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_UI])) {
            return;
        }
        if (!is_array($data[self::KEY_UI])) {
            return;
        }
        $model->setUi($this->appUiSettingsTransformer->transform($data[self::KEY_UI]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWebhookSmartApp(AppDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_WEBHOOK_SMART_APP])) {
            return;
        }
        if (!is_array($data[self::KEY_WEBHOOK_SMART_APP])) {
            return;
        }
        $model->setWebhookSmartApp($this->webhookSmartAppTransformer->transform($data[self::KEY_WEBHOOK_SMART_APP]));
    }
}
