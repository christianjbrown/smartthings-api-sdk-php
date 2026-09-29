<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BleD2DDeviceDetailsInterface
{
    public function getAdvertisingId(): ?string;

    public function getBleDeviceType(): ?string;

    public function getCipher(): ?string;

    public function getConfigurationUrl(): ?string;

    public function getConfigurationVersion(): ?string;

    public function getEncryptionKey(): ?string;

    public function getGattCipher(): ?string;

    public function getIdentifier(): ?string;

    /**
     * @return null|mixed[]
     */
    public function getMetadata(): ?array;

    public function setAdvertisingId(?string $value): self;

    public function setBleDeviceType(?string $value): self;

    public function setCipher(?string $value): self;

    public function setConfigurationUrl(?string $value): self;

    public function setConfigurationVersion(?string $value): self;

    public function setEncryptionKey(?string $value): self;

    public function setGattCipher(?string $value): self;

    public function setIdentifier(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setMetadata(?array $value): self;
}
