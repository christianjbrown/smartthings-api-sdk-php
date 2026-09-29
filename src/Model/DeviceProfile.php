<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceProfile implements DeviceProfileInterface
{
    /**
     * @var array<int, DeviceProfileComponentInterface>
     */
    private array $components = [];
    private string $id;

    /**
     * @var array<array-key, string>
     */
    private array $metadata = [];
    private ?string $migrationStatus = null;
    private ?string $name = null;

    /**
     * @var array<int, DevicePreferenceDefinitionInterface>
     */
    private array $preferences = [];
    private ?string $presentationId = null;
    private ?DeviceRestrictionInterface $restrictions = null;
    private ?string $status = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return array<int, DeviceProfileComponentInterface>
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array<array-key, string>
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function getMigrationStatus(): ?string
    {
        return $this->migrationStatus;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return array<int, DevicePreferenceDefinitionInterface>
     */
    public function getPreferences(): array
    {
        return $this->preferences;
    }

    public function getPresentationId(): ?string
    {
        return $this->presentationId;
    }

    public function getRestrictions(): ?DeviceRestrictionInterface
    {
        return $this->restrictions;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param array<int, DeviceProfileComponentInterface> $value
     */
    public function setComponents(array $value): DeviceProfileInterface
    {
        $this->components = $value;

        return $this;
    }

    public function setId(string $value): DeviceProfileInterface
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @param array<array-key, string> $value
     */
    public function setMetadata(array $value): DeviceProfileInterface
    {
        $this->metadata = $value;

        return $this;
    }

    public function setMigrationStatus(?string $value): DeviceProfileInterface
    {
        $this->migrationStatus = $value;

        return $this;
    }

    public function setName(?string $value): DeviceProfileInterface
    {
        $this->name = $value;

        return $this;
    }

    /**
     * @param array<int, DevicePreferenceDefinitionInterface> $value
     */
    public function setPreferences(array $value): DeviceProfileInterface
    {
        $this->preferences = $value;

        return $this;
    }

    public function setPresentationId(?string $value): DeviceProfileInterface
    {
        $this->presentationId = $value;

        return $this;
    }

    public function setRestrictions(?DeviceRestrictionInterface $value): DeviceProfileInterface
    {
        $this->restrictions = $value;

        return $this;
    }

    public function setStatus(?string $value): DeviceProfileInterface
    {
        $this->status = $value;

        return $this;
    }
}
