<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ServiceCapabilityDataAlertItemInterface
{
    public function getExpireTime(): ?ServiceCapabilityDataAlertItemLastUpdateTimeInterface;

    public function getHeadlineText(): ?ServiceCapabilityDataAlertItemLastUpdateTimeInterface;

    public function getIssueTime(): ?ServiceCapabilityDataAlertItemLastUpdateTimeInterface;

    public function getLastUpdateTime(): ?ServiceCapabilityDataAlertItemLastUpdateTimeInterface;

    public function getMessageType(): ?ServiceCapabilityDataAlertItemSeverityInterface;

    public function getSeverity(): ?ServiceCapabilityDataAlertItemSeverityInterface;

    public function setExpireTime(?ServiceCapabilityDataAlertItemLastUpdateTimeInterface $value): self;

    public function setHeadlineText(?ServiceCapabilityDataAlertItemLastUpdateTimeInterface $value): self;

    public function setIssueTime(?ServiceCapabilityDataAlertItemLastUpdateTimeInterface $value): self;

    public function setLastUpdateTime(?ServiceCapabilityDataAlertItemLastUpdateTimeInterface $value): self;

    public function setMessageType(?ServiceCapabilityDataAlertItemSeverityInterface $value): self;

    public function setSeverity(?ServiceCapabilityDataAlertItemSeverityInterface $value): self;
}
