<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class InstalledSchemaAppDetails implements InstalledSchemaAppDetailsInterface
{
    /**
     * @var null|array<int, DeviceResultsInterface>
     */
    private ?array $devices = null;
    private ?ViperAppLinksInterface $viperAppLinks = null;

    /**
     * @return null|array<int, DeviceResultsInterface>
     */
    public function getDevices(): ?array
    {
        return $this->devices;
    }

    public function getViperAppLinks(): ?ViperAppLinksInterface
    {
        return $this->viperAppLinks;
    }

    /**
     * @param null|array<int, DeviceResultsInterface> $value
     */
    public function setDevices(?array $value): InstalledSchemaAppDetailsInterface
    {
        $this->devices = $value;

        return $this;
    }

    public function setViperAppLinks(?ViperAppLinksInterface $value): InstalledSchemaAppDetailsInterface
    {
        $this->viperAppLinks = $value;

        return $this;
    }
}
