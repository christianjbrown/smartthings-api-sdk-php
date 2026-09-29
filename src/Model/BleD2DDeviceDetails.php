<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BleD2DDeviceDetails implements BleD2DDeviceDetailsInterface
{
    private ?string $advertisingId = null;
    private ?string $bleDeviceType = null;
    private ?string $cipher = null;
    private ?string $configurationUrl = null;
    private ?string $configurationVersion = null;
    private ?string $encryptionKey = null;
    private ?string $gattCipher = null;
    private ?string $identifier = null;

    /**
     * @var null|mixed[]
     */
    private ?array $metadata = null;

    public function getAdvertisingId(): ?string
    {
        return $this->advertisingId;
    }

    public function getBleDeviceType(): ?string
    {
        return $this->bleDeviceType;
    }

    public function getCipher(): ?string
    {
        return $this->cipher;
    }

    public function getConfigurationUrl(): ?string
    {
        return $this->configurationUrl;
    }

    public function getConfigurationVersion(): ?string
    {
        return $this->configurationVersion;
    }

    public function getEncryptionKey(): ?string
    {
        return $this->encryptionKey;
    }

    public function getGattCipher(): ?string
    {
        return $this->gattCipher;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    /**
     * @return null|mixed[]
     */
    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    public function setAdvertisingId(?string $value): BleD2DDeviceDetailsInterface
    {
        $this->advertisingId = $value;

        return $this;
    }

    public function setBleDeviceType(?string $value): BleD2DDeviceDetailsInterface
    {
        $this->bleDeviceType = $value;

        return $this;
    }

    public function setCipher(?string $value): BleD2DDeviceDetailsInterface
    {
        $this->cipher = $value;

        return $this;
    }

    public function setConfigurationUrl(?string $value): BleD2DDeviceDetailsInterface
    {
        $this->configurationUrl = $value;

        return $this;
    }

    public function setConfigurationVersion(?string $value): BleD2DDeviceDetailsInterface
    {
        $this->configurationVersion = $value;

        return $this;
    }

    public function setEncryptionKey(?string $value): BleD2DDeviceDetailsInterface
    {
        $this->encryptionKey = $value;

        return $this;
    }

    public function setGattCipher(?string $value): BleD2DDeviceDetailsInterface
    {
        $this->gattCipher = $value;

        return $this;
    }

    public function setIdentifier(?string $value): BleD2DDeviceDetailsInterface
    {
        $this->identifier = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setMetadata(?array $value): BleD2DDeviceDetailsInterface
    {
        $this->metadata = $value;

        return $this;
    }
}
