<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface OcfDeviceDetailsInterface
{
    public function getAdditionalAuthCodeRequired(): ?bool;

    public function getFirmwareVersion(): ?string;

    public function getHwVersion(): ?string;

    public function getLastSignupTime(): ?string;

    public function getLocale(): ?string;

    public function getManufacturerName(): ?string;

    public function getModelCode(): ?string;

    public function getModelNumber(): ?string;

    public function getName(): ?string;

    public function getOcfDeviceType(): ?string;

    public function getPlatformOS(): ?string;

    public function getPlatformVersion(): ?string;

    public function getSpecVersion(): ?string;

    public function getTransferCandidate(): ?bool;

    public function getVendorId(): ?string;

    public function getVendorResourceClientServerVersion(): ?string;

    public function getVerticalDomainSpecVersion(): ?string;

    public function setAdditionalAuthCodeRequired(?bool $value): self;

    public function setFirmwareVersion(?string $value): self;

    public function setHwVersion(?string $value): self;

    public function setLastSignupTime(?string $value): self;

    public function setLocale(?string $value): self;

    public function setManufacturerName(?string $value): self;

    public function setModelCode(?string $value): self;

    public function setModelNumber(?string $value): self;

    public function setName(?string $value): self;

    public function setOcfDeviceType(?string $value): self;

    public function setPlatformOS(?string $value): self;

    public function setPlatformVersion(?string $value): self;

    public function setSpecVersion(?string $value): self;

    public function setTransferCandidate(?bool $value): self;

    public function setVendorId(?string $value): self;

    public function setVendorResourceClientServerVersion(?string $value): self;

    public function setVerticalDomainSpecVersion(?string $value): self;
}
