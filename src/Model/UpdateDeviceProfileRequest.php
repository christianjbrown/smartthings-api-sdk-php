<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class UpdateDeviceProfileRequest implements UpdateDeviceProfileRequestInterface
{
    /**
     * @var null|array<int, mixed[]>
     */
    private ?array $components = null;

    /**
     * @var null|mixed[]
     */
    private ?array $metadata = null;

    /**
     * @var null|array<int, mixed[]>
     */
    private ?array $preferences = null;
    private ?string $presentationId = null;

    /**
     * @return null|array<int, mixed[]>
     */
    public function getComponents(): ?array
    {
        return $this->components;
    }

    /**
     * @return null|mixed[]
     */
    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    /**
     * @return null|array<int, mixed[]>
     */
    public function getPreferences(): ?array
    {
        return $this->preferences;
    }

    public function getPresentationId(): ?string
    {
        return $this->presentationId;
    }

    /**
     * @param null|array<int, mixed[]> $value
     */
    public function setComponents(?array $value): UpdateDeviceProfileRequestInterface
    {
        $this->components = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setMetadata(?array $value): UpdateDeviceProfileRequestInterface
    {
        $this->metadata = $value;

        return $this;
    }

    /**
     * @param null|array<int, mixed[]> $value
     */
    public function setPreferences(?array $value): UpdateDeviceProfileRequestInterface
    {
        $this->preferences = $value;

        return $this;
    }

    public function setPresentationId(?string $value): UpdateDeviceProfileRequestInterface
    {
        $this->presentationId = $value;

        return $this;
    }
}
