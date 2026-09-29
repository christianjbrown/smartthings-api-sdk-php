<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceProfileInterface
{
    /**
     * @return array<int, DeviceProfileComponentInterface>
     */
    public function getComponents(): array;

    public function getId(): string;

    /**
     * @return array<array-key, string>
     */
    public function getMetadata(): array;

    public function getMigrationStatus(): ?string;

    public function getName(): ?string;

    /**
     * @return array<int, DevicePreferenceDefinitionInterface>
     */
    public function getPreferences(): array;

    public function getPresentationId(): ?string;

    public function getRestrictions(): ?DeviceRestrictionInterface;

    public function getStatus(): ?string;

    /**
     * @param array<int, DeviceProfileComponentInterface> $value
     */
    public function setComponents(array $value): self;

    public function setId(string $value): self;

    /**
     * @param array<array-key, string> $value
     */
    public function setMetadata(array $value): self;

    public function setMigrationStatus(?string $value): self;

    public function setName(?string $value): self;

    /**
     * @param array<int, DevicePreferenceDefinitionInterface> $value
     */
    public function setPreferences(array $value): self;

    public function setPresentationId(?string $value): self;

    public function setRestrictions(?DeviceRestrictionInterface $value): self;

    public function setStatus(?string $value): self;
}
