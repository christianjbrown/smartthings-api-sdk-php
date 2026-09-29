<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

/**
 * A device profile's components, preferences, metadata and deviceConfig each follow
 * their own nested vendor schema (capability references, presentation hints, and so
 * on). Modeling every variant as its own typed class would add many classes out of
 * proportion with the rest of this SDK, so they are accepted here as raw arrays
 * shaped per the vendor's schema (https://developer.smartthings.com/docs/api/public/#operation/createDeviceProfile)
 * and passed through to the API unmodified.
 */
interface CreateDeviceProfileRequestInterface
{
    /**
     * @return array<int, DeviceProfileComponentRequestInterface|mixed[]>
     */
    public function getComponents(): array;

    /**
     * @return null|mixed[]
     */
    public function getDeviceConfig(): ?array;

    /**
     * @return null|mixed[]
     */
    public function getMetadata(): ?array;

    public function getName(): string;

    /**
     * @return null|array<int, mixed[]|PreferenceRequestInterface>
     */
    public function getPreferences(): ?array;

    public function getPresentationId(): ?string;

    /**
     * @param null|mixed[] $value
     */
    public function setDeviceConfig(?array $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setMetadata(?array $value): self;

    /**
     * @param null|array<int, mixed[]|PreferenceRequestInterface> $value
     */
    public function setPreferences(?array $value): self;

    public function setPresentationId(?string $value): self;
}
