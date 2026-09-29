<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface InstalledSchemaAppDetailsInterface
{
    /**
     * @return null|array<int, DeviceResultsInterface>
     */
    public function getDevices(): ?array;

    public function getViperAppLinks(): ?ViperAppLinksInterface;

    /**
     * @param null|array<int, DeviceResultsInterface> $value
     */
    public function setDevices(?array $value): self;

    public function setViperAppLinks(?ViperAppLinksInterface $value): self;
}
