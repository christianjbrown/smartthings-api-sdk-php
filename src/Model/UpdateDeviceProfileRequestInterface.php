<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

/**
 * See CreateDeviceProfileRequestInterface for why components, preferences and
 * metadata are accepted as raw arrays rather than fully typed nested models.
 */
interface UpdateDeviceProfileRequestInterface
{
    /**
     * @return null|array<int, mixed[]>
     */
    public function getComponents(): ?array;

    /**
     * @return null|mixed[]
     */
    public function getMetadata(): ?array;

    /**
     * @return null|array<int, mixed[]>
     */
    public function getPreferences(): ?array;

    public function getPresentationId(): ?string;

    /**
     * @param null|array<int, mixed[]> $value
     */
    public function setComponents(?array $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setMetadata(?array $value): self;

    /**
     * @param null|array<int, mixed[]> $value
     */
    public function setPreferences(?array $value): self;

    public function setPresentationId(?string $value): self;
}
