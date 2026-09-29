<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface IrDeviceDetailsInterface
{
    /**
     * @return null|array<int, IrDeviceDetailsInterface>
     */
    public function getChildDevices(): ?array;

    public function getFunctionCodes(): ?IrDeviceDetailsFunctionCodesInterface;

    public function getIrCode(): ?string;

    /**
     * @return null|mixed[]
     */
    public function getMetadata(): ?array;

    public function getOcfDeviceType(): ?string;

    public function getParentDeviceId(): ?string;

    public function getProfileId(): ?string;

    /**
     * @param null|array<int, IrDeviceDetailsInterface> $value
     */
    public function setChildDevices(?array $value): self;

    public function setFunctionCodes(?IrDeviceDetailsFunctionCodesInterface $value): self;

    public function setIrCode(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setMetadata(?array $value): self;

    public function setOcfDeviceType(?string $value): self;

    public function setParentDeviceId(?string $value): self;

    public function setProfileId(?string $value): self;
}
