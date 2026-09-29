<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class OcfDeviceDetails implements OcfDeviceDetailsInterface
{
    private ?bool $additionalAuthCodeRequired = null;
    private ?string $firmwareVersion = null;
    private ?string $hwVersion = null;
    private ?string $lastSignupTime = null;
    private ?string $locale = null;
    private ?string $manufacturerName = null;
    private ?string $modelCode = null;
    private ?string $modelNumber = null;
    private ?string $name = null;
    private ?string $ocfDeviceType = null;
    private ?string $platformOS = null;
    private ?string $platformVersion = null;
    private ?string $specVersion = null;
    private ?bool $transferCandidate = null;
    private ?string $vendorId = null;
    private ?string $vendorResourceClientServerVersion = null;
    private ?string $verticalDomainSpecVersion = null;

    public function getAdditionalAuthCodeRequired(): ?bool
    {
        return $this->additionalAuthCodeRequired;
    }

    public function getFirmwareVersion(): ?string
    {
        return $this->firmwareVersion;
    }

    public function getHwVersion(): ?string
    {
        return $this->hwVersion;
    }

    public function getLastSignupTime(): ?string
    {
        return $this->lastSignupTime;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function getManufacturerName(): ?string
    {
        return $this->manufacturerName;
    }

    public function getModelCode(): ?string
    {
        return $this->modelCode;
    }

    public function getModelNumber(): ?string
    {
        return $this->modelNumber;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOcfDeviceType(): ?string
    {
        return $this->ocfDeviceType;
    }

    public function getPlatformOS(): ?string
    {
        return $this->platformOS;
    }

    public function getPlatformVersion(): ?string
    {
        return $this->platformVersion;
    }

    public function getSpecVersion(): ?string
    {
        return $this->specVersion;
    }

    public function getTransferCandidate(): ?bool
    {
        return $this->transferCandidate;
    }

    public function getVendorId(): ?string
    {
        return $this->vendorId;
    }

    public function getVendorResourceClientServerVersion(): ?string
    {
        return $this->vendorResourceClientServerVersion;
    }

    public function getVerticalDomainSpecVersion(): ?string
    {
        return $this->verticalDomainSpecVersion;
    }

    public function setAdditionalAuthCodeRequired(?bool $value): OcfDeviceDetailsInterface
    {
        $this->additionalAuthCodeRequired = $value;

        return $this;
    }

    public function setFirmwareVersion(?string $value): OcfDeviceDetailsInterface
    {
        $this->firmwareVersion = $value;

        return $this;
    }

    public function setHwVersion(?string $value): OcfDeviceDetailsInterface
    {
        $this->hwVersion = $value;

        return $this;
    }

    public function setLastSignupTime(?string $value): OcfDeviceDetailsInterface
    {
        $this->lastSignupTime = $value;

        return $this;
    }

    public function setLocale(?string $value): OcfDeviceDetailsInterface
    {
        $this->locale = $value;

        return $this;
    }

    public function setManufacturerName(?string $value): OcfDeviceDetailsInterface
    {
        $this->manufacturerName = $value;

        return $this;
    }

    public function setModelCode(?string $value): OcfDeviceDetailsInterface
    {
        $this->modelCode = $value;

        return $this;
    }

    public function setModelNumber(?string $value): OcfDeviceDetailsInterface
    {
        $this->modelNumber = $value;

        return $this;
    }

    public function setName(?string $value): OcfDeviceDetailsInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setOcfDeviceType(?string $value): OcfDeviceDetailsInterface
    {
        $this->ocfDeviceType = $value;

        return $this;
    }

    public function setPlatformOS(?string $value): OcfDeviceDetailsInterface
    {
        $this->platformOS = $value;

        return $this;
    }

    public function setPlatformVersion(?string $value): OcfDeviceDetailsInterface
    {
        $this->platformVersion = $value;

        return $this;
    }

    public function setSpecVersion(?string $value): OcfDeviceDetailsInterface
    {
        $this->specVersion = $value;

        return $this;
    }

    public function setTransferCandidate(?bool $value): OcfDeviceDetailsInterface
    {
        $this->transferCandidate = $value;

        return $this;
    }

    public function setVendorId(?string $value): OcfDeviceDetailsInterface
    {
        $this->vendorId = $value;

        return $this;
    }

    public function setVendorResourceClientServerVersion(?string $value): OcfDeviceDetailsInterface
    {
        $this->vendorResourceClientServerVersion = $value;

        return $this;
    }

    public function setVerticalDomainSpecVersion(?string $value): OcfDeviceDetailsInterface
    {
        $this->verticalDomainSpecVersion = $value;

        return $this;
    }
}
