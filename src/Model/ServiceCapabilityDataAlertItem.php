<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ServiceCapabilityDataAlertItem implements ServiceCapabilityDataAlertItemInterface
{
    private ?ServiceCapabilityDataAlertItemLastUpdateTimeInterface $expireTime = null;
    private ?ServiceCapabilityDataAlertItemLastUpdateTimeInterface $headlineText = null;
    private ?ServiceCapabilityDataAlertItemLastUpdateTimeInterface $issueTime = null;
    private ?ServiceCapabilityDataAlertItemLastUpdateTimeInterface $lastUpdateTime = null;
    private ?ServiceCapabilityDataAlertItemSeverityInterface $messageType = null;
    private ?ServiceCapabilityDataAlertItemSeverityInterface $severity = null;

    public function getExpireTime(): ?ServiceCapabilityDataAlertItemLastUpdateTimeInterface
    {
        return $this->expireTime;
    }

    public function getHeadlineText(): ?ServiceCapabilityDataAlertItemLastUpdateTimeInterface
    {
        return $this->headlineText;
    }

    public function getIssueTime(): ?ServiceCapabilityDataAlertItemLastUpdateTimeInterface
    {
        return $this->issueTime;
    }

    public function getLastUpdateTime(): ?ServiceCapabilityDataAlertItemLastUpdateTimeInterface
    {
        return $this->lastUpdateTime;
    }

    public function getMessageType(): ?ServiceCapabilityDataAlertItemSeverityInterface
    {
        return $this->messageType;
    }

    public function getSeverity(): ?ServiceCapabilityDataAlertItemSeverityInterface
    {
        return $this->severity;
    }

    public function setExpireTime(?ServiceCapabilityDataAlertItemLastUpdateTimeInterface $value): ServiceCapabilityDataAlertItemInterface
    {
        $this->expireTime = $value;

        return $this;
    }

    public function setHeadlineText(?ServiceCapabilityDataAlertItemLastUpdateTimeInterface $value): ServiceCapabilityDataAlertItemInterface
    {
        $this->headlineText = $value;

        return $this;
    }

    public function setIssueTime(?ServiceCapabilityDataAlertItemLastUpdateTimeInterface $value): ServiceCapabilityDataAlertItemInterface
    {
        $this->issueTime = $value;

        return $this;
    }

    public function setLastUpdateTime(?ServiceCapabilityDataAlertItemLastUpdateTimeInterface $value): ServiceCapabilityDataAlertItemInterface
    {
        $this->lastUpdateTime = $value;

        return $this;
    }

    public function setMessageType(?ServiceCapabilityDataAlertItemSeverityInterface $value): ServiceCapabilityDataAlertItemInterface
    {
        $this->messageType = $value;

        return $this;
    }

    public function setSeverity(?ServiceCapabilityDataAlertItemSeverityInterface $value): ServiceCapabilityDataAlertItemInterface
    {
        $this->severity = $value;

        return $this;
    }
}
