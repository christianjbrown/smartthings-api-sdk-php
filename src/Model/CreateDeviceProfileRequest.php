<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CreateDeviceProfileRequest implements CreateDeviceProfileRequestInterface
{
    /**
     * @var array<int, mixed[]>
     */
    private array $components;

    /**
     * @var null|mixed[]
     */
    private ?array $deviceConfig = null;

    /**
     * @var null|mixed[]
     */
    private ?array $metadata = null;
    private string $name;

    /**
     * @var null|array<int, mixed[]>
     */
    private ?array $preferences = null;
    private ?string $presentationId = null;

    /**
     * @phpstan-param array<int, mixed[]> $components
     */
    public function __construct(string $name, array $components)
    {
        $this->name = $name;
        $this->components = $components;
    }

    /**
     * @return array<int, mixed[]>
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * @return null|mixed[]
     */
    public function getDeviceConfig(): ?array
    {
        return $this->deviceConfig;
    }

    /**
     * @return null|mixed[]
     */
    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    public function getName(): string
    {
        return $this->name;
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
     * @param null|mixed[] $value
     */
    public function setDeviceConfig(?array $value): CreateDeviceProfileRequestInterface
    {
        $this->deviceConfig = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setMetadata(?array $value): CreateDeviceProfileRequestInterface
    {
        $this->metadata = $value;

        return $this;
    }

    /**
     * @param null|array<int, mixed[]> $value
     */
    public function setPreferences(?array $value): CreateDeviceProfileRequestInterface
    {
        $this->preferences = $value;

        return $this;
    }

    public function setPresentationId(?string $value): CreateDeviceProfileRequestInterface
    {
        $this->presentationId = $value;

        return $this;
    }
}
