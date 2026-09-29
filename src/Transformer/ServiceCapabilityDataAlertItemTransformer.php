<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItem;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemInterface;

use function is_array;

final class ServiceCapabilityDataAlertItemTransformer implements ServiceCapabilityDataAlertItemTransformerInterface
{
    private ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface $serviceCapabilityDataAlertItemLastUpdateTimeTransformer;
    private ServiceCapabilityDataAlertItemSeverityTransformerInterface $serviceCapabilityDataAlertItemSeverityTransformer;

    public function __construct(ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface $serviceCapabilityDataAlertItemLastUpdateTimeTransformer, ServiceCapabilityDataAlertItemSeverityTransformerInterface $serviceCapabilityDataAlertItemSeverityTransformer)
    {
        $this->serviceCapabilityDataAlertItemLastUpdateTimeTransformer = $serviceCapabilityDataAlertItemLastUpdateTimeTransformer;
        $this->serviceCapabilityDataAlertItemSeverityTransformer = $serviceCapabilityDataAlertItemSeverityTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceCapabilityDataAlertItemInterface
    {
        $model = new ServiceCapabilityDataAlertItem();

        $this->applyLastUpdateTime($model, $data);
        $this->applyHeadlineText($model, $data);
        $this->applySeverity($model, $data);
        $this->applyMessageType($model, $data);
        $this->applyIssueTime($model, $data);
        $this->applyExpireTime($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyExpireTime(ServiceCapabilityDataAlertItem $model, array $data): void
    {
        if (!isset($data[self::KEY_EXPIRE_TIME])) {
            return;
        }
        if (!is_array($data[self::KEY_EXPIRE_TIME])) {
            return;
        }
        $model->setExpireTime($this->serviceCapabilityDataAlertItemLastUpdateTimeTransformer->transform($data[self::KEY_EXPIRE_TIME]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyHeadlineText(ServiceCapabilityDataAlertItem $model, array $data): void
    {
        if (!isset($data[self::KEY_HEADLINE_TEXT])) {
            return;
        }
        if (!is_array($data[self::KEY_HEADLINE_TEXT])) {
            return;
        }
        $model->setHeadlineText($this->serviceCapabilityDataAlertItemLastUpdateTimeTransformer->transform($data[self::KEY_HEADLINE_TEXT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyIssueTime(ServiceCapabilityDataAlertItem $model, array $data): void
    {
        if (!isset($data[self::KEY_ISSUE_TIME])) {
            return;
        }
        if (!is_array($data[self::KEY_ISSUE_TIME])) {
            return;
        }
        $model->setIssueTime($this->serviceCapabilityDataAlertItemLastUpdateTimeTransformer->transform($data[self::KEY_ISSUE_TIME]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLastUpdateTime(ServiceCapabilityDataAlertItem $model, array $data): void
    {
        if (!isset($data[self::KEY_LAST_UPDATE_TIME])) {
            return;
        }
        if (!is_array($data[self::KEY_LAST_UPDATE_TIME])) {
            return;
        }
        $model->setLastUpdateTime($this->serviceCapabilityDataAlertItemLastUpdateTimeTransformer->transform($data[self::KEY_LAST_UPDATE_TIME]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyMessageType(ServiceCapabilityDataAlertItem $model, array $data): void
    {
        if (!isset($data[self::KEY_MESSAGE_TYPE])) {
            return;
        }
        if (!is_array($data[self::KEY_MESSAGE_TYPE])) {
            return;
        }
        $model->setMessageType($this->serviceCapabilityDataAlertItemSeverityTransformer->transform($data[self::KEY_MESSAGE_TYPE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySeverity(ServiceCapabilityDataAlertItem $model, array $data): void
    {
        if (!isset($data[self::KEY_SEVERITY])) {
            return;
        }
        if (!is_array($data[self::KEY_SEVERITY])) {
            return;
        }
        $model->setSeverity($this->serviceCapabilityDataAlertItemSeverityTransformer->transform($data[self::KEY_SEVERITY]));
    }
}
