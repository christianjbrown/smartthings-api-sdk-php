<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class IrDeviceDetails implements IrDeviceDetailsInterface
{
    /**
     * @var null|array<int, IrDeviceDetailsInterface>
     */
    private ?array $childDevices = null;
    private ?IrDeviceDetailsFunctionCodesInterface $functionCodes = null;
    private ?string $irCode = null;

    /**
     * @var null|mixed[]
     */
    private ?array $metadata = null;
    private ?string $ocfDeviceType = null;
    private ?string $parentDeviceId = null;
    private ?string $profileId = null;

    /**
     * @return null|array<int, IrDeviceDetailsInterface>
     */
    public function getChildDevices(): ?array
    {
        return $this->childDevices;
    }

    public function getFunctionCodes(): ?IrDeviceDetailsFunctionCodesInterface
    {
        return $this->functionCodes;
    }

    public function getIrCode(): ?string
    {
        return $this->irCode;
    }

    /**
     * @return null|mixed[]
     */
    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    public function getOcfDeviceType(): ?string
    {
        return $this->ocfDeviceType;
    }

    public function getParentDeviceId(): ?string
    {
        return $this->parentDeviceId;
    }

    public function getProfileId(): ?string
    {
        return $this->profileId;
    }

    /**
     * @param null|array<int, IrDeviceDetailsInterface> $value
     */
    public function setChildDevices(?array $value): IrDeviceDetailsInterface
    {
        $this->childDevices = $value;

        return $this;
    }

    public function setFunctionCodes(?IrDeviceDetailsFunctionCodesInterface $value): IrDeviceDetailsInterface
    {
        $this->functionCodes = $value;

        return $this;
    }

    public function setIrCode(?string $value): IrDeviceDetailsInterface
    {
        $this->irCode = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setMetadata(?array $value): IrDeviceDetailsInterface
    {
        $this->metadata = $value;

        return $this;
    }

    public function setOcfDeviceType(?string $value): IrDeviceDetailsInterface
    {
        $this->ocfDeviceType = $value;

        return $this;
    }

    public function setParentDeviceId(?string $value): IrDeviceDetailsInterface
    {
        $this->parentDeviceId = $value;

        return $this;
    }

    public function setProfileId(?string $value): IrDeviceDetailsInterface
    {
        $this->profileId = $value;

        return $this;
    }
}
